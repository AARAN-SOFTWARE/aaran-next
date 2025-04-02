<div>

    <div class="pt-5">
        <div>
            @if ($monthlyTotals->isEmpty())
                <p>No sales data available for this company.</p>
            @else
                <canvas id="myChart" style="width:100%; max-width:600px;"></canvas>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Get month and total values
                        var xValues = @json($monthlyTotals->pluck('month')); // Month numbers
                        var yValues = @json($monthlyTotals->pluck('total')); // Corresponding sales totals

                        // Reorder months to start from April and end in March
                        const reorderedMonths = [];
                        const reorderedValues = [];

                        // Create an array to map month numbers to their corresponding index
                        const monthMap = {
                            1: 9, // January -> 10
                            2: 10, // February -> 11
                            3: 11, // March -> 12
                            4: 0,  // April -> 0
                            5: 1,  // May -> 1
                            6: 2,  // June -> 2
                            7: 3,  // July -> 3
                            8: 4,  // August -> 4
                            9: 5,  // September -> 5
                            10: 6, // October -> 6
                            11: 7, // November -> 7
                            12: 8, // December -> 8
                        };

                        for (let i = 1; i <= 12; i++) {
                            const monthIndex = monthMap[i];
                            if (xValues.includes(i)) {
                                reorderedMonths[monthIndex] = monthNames[i - 1]; // Set month name at correct index
                                reorderedValues[monthIndex] = yValues[xValues.indexOf(i)]; // Set total at correct index
                            } else {
                                reorderedMonths[monthIndex] = monthNames[i - 1]; // Fill with month names even if no data exists
                                reorderedValues[monthIndex] = null; // No data for this month
                            }
                        }

                        var barColors = Array(reorderedMonths.length).fill("#23B7E5"); // Set color for each bar

                        new Chart("myChart", {
                            type: "bar",
                            data: {
                                labels: reorderedMonths,
                                datasets: [{
                                    data: reorderedValues,
                                    backgroundColor: barColors,
                                }]
                            },
                            options: {
                                legend: {
                                    display: false
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    });

                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                </script>

                {{--                                <script>--}}
                {{--                                    document.addEventListener('DOMContentLoaded', function () {--}}
                {{--                                        var xValues = @json($monthlyTotals->pluck('month')); // Corrected--}}
                {{--                                        var yValues = @json($monthlyTotals->pluck('total')); // Corrected--}}

                {{--                                        var barColors = Array(xValues.length).fill("#23B7E5"); // Set color for each bar--}}
                {{--                                        new Chart("myChart", {--}}
                {{--                                            type: "bar",--}}
                {{--                                            data: {--}}
                {{--                                                labels: xValues.map(month => monthNames[month - 1]), // Convert month numbers to names--}}
                {{--                                                datasets: [{--}}
                {{--                                                    data: yValues,--}}
                {{--                                                    backgroundColor: barColors,--}}
                {{--                                                }]--}}
                {{--                                            },--}}
                {{--                                            options: {--}}
                {{--                                                legend: {--}}
                {{--                                                    display: false--}}
                {{--                                                },--}}
                {{--                                                scales: {--}}
                {{--                                                    yAxes: [{--}}
                {{--                                                        ticks: {--}}
                {{--                                                            beginAtZero: true--}}
                {{--                                                        }--}}
                {{--                                                    }]--}}
                {{--                                                }--}}
                {{--                                            }--}}
                {{--                                        });--}}
                {{--                                    });--}}

                {{--                                    // Month names for better readability--}}
                {{--                                    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];--}}
                {{--                                </script>--}}
            @endif
        </div>


    </div>
</div>
