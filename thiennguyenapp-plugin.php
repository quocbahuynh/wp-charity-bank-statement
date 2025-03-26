<?php
/**
 * Plugin Name: WP Charity Bank Statement
 * Description: Giúp hiển thị sao kê giao dịch ngân hàng của tổ chức từ thiện một cách minh bạch và chuyên nghiệp. Plugin cho phép người dùng tìm kiếm, lọc và phân trang danh sách giao dịch từ ngân hàng MB Bank.
 * Version: 1.3
 * Author: Huỳnh Bá Quốc
 */

if (!defined('ABSPATH')) {
    exit; 
}

class WP_Transactions_Display {
    private $api_base = 'https://apiv2.thiennguyen.app/api/v2/report/';

    public function __construct() {
        add_shortcode('transactions_display', [$this, 'render_transactions']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_fetch_transactions', [$this, 'fetch_transactions']);
        add_action('wp_ajax_nopriv_fetch_transactions', [$this, 'fetch_transactions']);

        // Admin settings
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function enqueue_scripts() {
        wp_enqueue_style('transactions-style', plugin_dir_url(__FILE__) . 'style.css');
        wp_enqueue_script('transactions-script', plugin_dir_url(__FILE__) . 'script.js', ['jquery'], null, true);
        wp_localize_script('transactions-script', 'transactionsAjax', [
            'ajaxurl' => admin_url('admin-ajax.php'),
        ]);
    }

    public function render_transactions() {
        ob_start();
        ?>
        <div class="transactions-container container mt-4">
            <div class="row mb-31">
                <div class="col-md-4">
                    <input type="text" id="transaction-search" class="form-control" placeholder="Tìm kiếm...">
                </div>
                <div class="col-md-3">
                    <input type="date" id="from-date" class="form-control">
                </div>
                <div class="col-md-3">
                    <input type="date" id="to-date" class="form-control">
                </div>
                <div class="col-md-2">
                    <button id="filter-transactions" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>

            <div class="transactions-list-container">
                <table class="table">
                    <thead class="table charity-thread">
                        <tr>
                            <th class="text-center">Thời Gian</th>
                            <th class="text-center">Số Tiền</th>
                            <th class="text-left">Mô Tả</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-list"></tbody>
                </table>
            </div>

            <div class="text-center">
                <button id="load-more" class="btn btn-primary">Tải thêm</button>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function fetch_transactions() {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $keyword = isset($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';
        $from_date = isset($_POST['fromDate']) ? sanitize_text_field($_POST['fromDate']) : '';
        $to_date = isset($_POST['toDate']) ? sanitize_text_field($_POST['toDate']) : '';
        $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'CREDIT'; // Default to CREDIT

        // Get bank account ID from settings
        $bank_id = get_option('transactions_bank_id', '2660'); // Default to 2660 if not set
        $url = $this->api_base . $bank_id . '/transactions';
        $url .= "?pageNumber=$page&pageSize=20&type=$type&keyword=$keyword";

        if ($from_date && $to_date) {
            $url .= "&fromDate={$from_date}T00:00:00&toDate={$to_date}T23:59:59";
        }

        $response = wp_remote_get($url);
        if (is_wp_error($response)) {
            wp_send_json_error(['message' => 'Error fetching data']);
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (isset($data['data']['items'])) {
            wp_send_json_success($data['data']['items']);
        } else {
            wp_send_json_error(['message' => 'No data found']);
        }
    }

    // Admin Settings Page
    public function add_admin_menu() {
        add_menu_page(
            'Transactions Settings',
            'Transactions Settings',
            'manage_options',
            'transactions-settings',
            [$this, 'settings_page']
        );
    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h1>Transactions API Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('transactions_settings');
                do_settings_sections('transactions-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting('transactions_settings', 'transactions_bank_id');

        add_settings_section(
            'transactions_main_section',
            'Bank Account Settings',
            null,
            'transactions-settings'
        );

        add_settings_field(
            'transactions_bank_id',
            'Bank Account ID:',
            [$this, 'bank_id_input'],
            'transactions-settings',
            'transactions_main_section'
        );
    }

    public function bank_id_input() {
        $bank_id = get_option('transactions_bank_id', '2660');
        echo '<input type="text" name="transactions_bank_id" value="' . esc_attr($bank_id) . '" />';
    }
}

new WP_Transactions_Display();

