import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", () => {
    // init for token sales chart
    const tokenSalesEle = document.getElementById("tokenSales");

    if (tokenSalesEle) {
        const tokenSales = JSON.parse(tokenSalesEle.dataset.data || []);
        new Chart(tokenSalesEle, {
            type: "line",
            data: {
                labels: tokenSales.map((sale) => formatDate(sale.date)),
                datasets: [
                    {
                        label: "Tokens Amount",
                        tension: 0.4,
                        backgroundColor: "transparent",
                        borderColor: "rgb(29, 78, 216)",
                        pointBorderColor: "rgb(29, 78, 216)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgb(29, 78, 216)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 6,
                        pointHitRadius: 6,
                        data: tokenSales.map((sale) => sale.bought_amount),
                    },
                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    maintainAspectRatio: false,
                    tooltip: {
                        callbacks: {
                            title: function (t) {
                                return "Date: " + t[0].label;
                            },
                            label: function (t) {
                                return `Amount: ${t.formattedValue} ${
                                    window.settings.token_symbol || "TOKEN"
                                }`;
                            },
                        },
                        backgroundColor: "rgb(29, 78, 216)",
                        titleSize: 13,
                        // titleMarginBottom: 10,
                        bodySize: 14,
                        bodySpacing: 4,
                        yPadding: 15,
                        xPadding: 15,
                        footerMarginTop: 5,
                        displayColors: false,
                    },
                },
            },
        });
    }
    // init for referral vists chart
    const referralVisitsEle = document.getElementById("referralVisits");

    if (referralVisitsEle) {
        const referralVisits = JSON.parse(referralVisitsEle.dataset.data || []);
        new Chart(referralVisitsEle, {
            type: "line",
            data: {
                labels: referralVisits.map((sale) => formatDate(sale.date)),
                datasets: [
                    {
                        label: "Tokens Amount",
                        tension: 0.4,
                        backgroundColor: "transparent",
                        borderColor: "rgb(29, 78, 216)",
                        pointBorderColor: "rgb(29, 78, 216)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgb(29, 78, 216)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 6,
                        pointHitRadius: 6,
                        data: referralVisits.map((sale) => sale.visits),
                    },
                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    maintainAspectRatio: false,
                    tooltip: {
                        callbacks: {
                            title: function (t) {
                                return "Date: " + t[0].label;
                            },
                            label: function (t) {
                                return `Visits: ${t.formattedValue}`;
                            },
                        },
                        backgroundColor: "rgb(29, 78, 216)",
                        titleSize: 13,
                        // titleMarginBottom: 10,
                        bodySize: 14,
                        bodySpacing: 4,
                        yPadding: 15,
                        xPadding: 15,
                        footerMarginTop: 5,
                        displayColors: false,
                    },
                },
            },
        });
    }

    // init for kyc applications chart
    const kycApplicationsEle = document.getElementById("kycApplications");

    if (kycApplicationsEle) {
        const kycApplications = JSON.parse(
            kycApplicationsEle.dataset.data || []
        );
        new Chart(kycApplicationsEle, {
            type: "line",
            data: {
                labels: kycApplications.map((kyc) => formatDate(kyc.date)),
                datasets: [
                    {
                        label: "Applications",
                        tension: 0.4,
                        backgroundColor: "transparent",
                        borderColor: "rgb(29, 78, 216)",
                        pointBorderColor: "rgb(29, 78, 216)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 2,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgb(29, 78, 216)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 6,
                        pointHitRadius: 6,
                        data: kycApplications.map((kyc) => kyc.count),
                    },
                ],
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                    maintainAspectRatio: false,
                    tooltip: {
                        callbacks: {
                            title: function (t) {
                                return "Date: " + t[0].label;
                            },
                            label: function (t) {
                                return `Applications: ${t.formattedValue}`;
                            },
                        },
                        backgroundColor: "rgb(29, 78, 216)",
                        titleSize: 13,
                        // titleMarginBottom: 10,
                        bodySize: 14,
                        bodySpacing: 4,
                        yPadding: 15,
                        xPadding: 15,
                        footerMarginTop: 5,
                        displayColors: false,
                    },
                },
                scales: {
                    y: {
                        ticks: { precision: 0 },
                    },
                },
            },
        });
    }
});

const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
];

function formatDate(date) {
    const d = new Date(date);
    const month = "" + (d.getMonth() + 1);
    const day = d.getDate() < 10 ? "0" + d.getDate() : d.getDate();

    return `${day} ${monthNames[month - 1].slice(0, 3)}`;
}
