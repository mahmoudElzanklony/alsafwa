<script>
import { Line } from 'vue-chartjs';

export default {
    extends:Line,
    props:['chart_data'],
    data() {
        return {
            chartData: {
                labels: [
                    "يناير",
                    "فبراير",
                    "مارس",
                    "ابريل",
                    "مايو",
                    "يونيو",
                    "يوليو",
                    "اغسطس",
                    "سبتمر",
                    "اكتوبر",
                    "نوفمبر",
                    "ديسمبر"
                ],
                datasets: [
                    {
                        label: 'احصائيات العام',
                        data: this.chart_data,
                        fill: false,
                        borderColor: '#2554FF',
                        backgroundColor: '#2554FF',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                    xAxes: [ {
                        gridLines: {
                            display: false
                        }
                    }]
                },
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted() {
        //renderChart function renders the chart with the datacollection and options object.
        this.renderChart(this.chartData, this.options)
    },
    methods:{
        chartData: function() {
            return this.chart_data;
        }
    },
    watch:{
        chart_data:function (to,from){
            console.log(to);
            console.log(from);
            console.log(this.$data._chart);

            this.$nextTick(() => {
                this.renderChart(this.data, this.options);
            })
           // this.renderLineChart();

        }
    }
}
</script>

