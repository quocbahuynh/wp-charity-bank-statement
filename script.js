function formatDateTime(isoString) {
    const date = new Date(isoString);

    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    const year = date.getFullYear();
    
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${day}/${month}/${year} ${hours}:${minutes}`;
}

document.addEventListener("DOMContentLoaded", function () {
    let page = 1;

    function loadTransactions(reset = false) {
        const keyword = document.getElementById("transaction-search").value;
        const fromDate = document.getElementById("from-date").value;
        const toDate = document.getElementById("to-date").value;
        const type = document.getElementById("transaction-type")?.value || "CREDIT"; 

        const formData = new URLSearchParams();
        formData.append("action", "fetch_transactions");
        formData.append("page", page);
        formData.append("keyword", keyword);
        formData.append("fromDate", fromDate);
        formData.append("toDate", toDate);
        formData.append("type", type);

        console.log("Sending request:", formData.toString());

        fetch(transactionsAjax.ajaxurl, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let transactions = data.data;
                let html = "";

                transactions.forEach(transaction => {
                    let amountColor = transaction.type === "CREDIT" ? "text-success" : "text-danger";
                    let amountSign = transaction.type === "CREDIT" ? `+${transaction.transactionAmount.toLocaleString()}` : `-${transaction.transactionAmount}`;

                    html += `
                        <tr>
                            <td>${formatDateTime(transaction.transactionTime)}</td>
                            <td class="${amountColor}>${amountSign}</td>
                            <td>${transaction.narrative}</td>
                        </tr>
                    `;
                });

                if (reset) {
                    document.getElementById("transaction-list").innerHTML = html;
                } else {
                    document.getElementById("transaction-list").insertAdjacentHTML("beforeend", html);
                }

                page++;
            } else {
                document.getElementById("load-more").textContent = "No more transactions";
                document.getElementById("load-more").disabled = true;
            }
        })
        .catch(error => {
            console.error("Error fetching transactions:", error);
        })
        .finally(() => {
            document.getElementById("load-more").textContent = "Tải thêm";
        });
    }

    loadTransactions(true);

    document.getElementById("filter-transactions").addEventListener("click", function () {
        page = 1;
        loadTransactions(true);
    });

    document.getElementById("load-more").addEventListener("click", function () {
        loadTransactions();
    });
});
