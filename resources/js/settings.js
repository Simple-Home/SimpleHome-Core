let diskChartSelector = "server-disk-chart";
let cpuChartSelector = "server-cpu-chart";
let memoryChartSelector = "server-memory-chart";
const Chart = require("chart.js/dist/chart");

$(document).ready(function () {
    let dashboard = document.getElementById("server-dashboard");
    if (dashboard !== null) {
        let diskElement = document.getElementById(diskChartSelector);
        if (diskElement != null) {
            let canvas = document.createElement("canvas");
            diskElement.append(canvas);
            window.chartDisk = new Chart(canvas, {
                type: "doughnut",
                data: {
                    labels: ["Free", "Used"],
                    datasets: [
                        {
                            backgroundColor: [
                                "rgb(58, 228, 131)",
                                "rgb(234, 84, 85)",
                                "rgb(255, 165, 0)",
                            ],
                            data: [0, 0],
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: false,
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label || "";
                                    return (
                                        label +
                                        " " +
                                        context.formattedValue +
                                        " GB"
                                    );
                                },
                            },
                        },
                    },
                },
            });
            $("#" + diskElement.dataset.spinner).hide();
        }

        let cpuElement = document.getElementById(cpuChartSelector);
        if (cpuElement != null) {
            let canvas = document.createElement("canvas");
            cpuElement.append(canvas);
            window.chartCpu = new Chart(canvas, {
                type: "doughnut",
                data: {
                    labels: ["Used", "Free"],
                    datasets: [
                        {
                            backgroundColor: [
                                "rgb(234, 84, 85)",
                                "rgb(58, 228, 131)",
                            ],
                            data: [0, 0],
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: false,
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label || "";
                                    return (
                                        label +
                                        " " +
                                        context.formattedValue +
                                        " %"
                                    );
                                },
                            },
                        },
                    },
                },
            });
            $("#" + cpuElement.dataset.spinner).hide();
        }

        let memoryElement = document.getElementById(memoryChartSelector);
        if (memoryElement != null) {
            let canvas = document.createElement("canvas");
            memoryElement.append(canvas);
            window.chartMemory = new Chart(canvas, {
                type: "doughnut",
                data: {
                    labels: ["Used", "Free"],
                    datasets: [
                        {
                            backgroundColor: [
                                "rgb(234, 84, 85)",
                                "rgb(58, 228, 131)",
                            ],
                            data: [0, 0],
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: false,
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    var label = context.label || "";
                                    return (
                                        label +
                                        " " +
                                        context.formattedValue +
                                        " GB"
                                    );
                                },
                            },
                        },
                    },
                },
            });

            $("#" + memoryElement.dataset.spinner).hide();
        }

        function refreshChart() {
            let timeout = $("#refresh-chart option:selected").val() * 1000;
            setTimeout(function () {
                getChartData();
                refreshChart();
            }, timeout);
        }

        function getChartData() {   
            $.ajax({
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: dashboard.dataset.chartEndpoint,
                success: function (data) {
                    updateChart(window.chartDisk, data.disk);
                    updateChart(window.chartCpu, data.cpu);
                    updateChart(window.chartMemory, data.memory);
                },
            });
        }

        function updateChart(chart, dataObject) {
            chart.data.datasets[0].data = null;
            chart.data.labels = null;
            chart.data.labels = Object.keys(dataObject);
            chart.data.datasets[0].data = Object.values(dataObject);
            chart.update();
        }

        getChartData();
        refreshChart();
    }
});
