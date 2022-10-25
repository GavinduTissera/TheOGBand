var xValues = ["OCT 2021", "NOV 2021","DEC 2021", "JAN 2022", "FEB 2022", "MAR 2022", "APR 2022", "MAY 2022", "JUNE 2022", "JULY 2022", "AUG 2022", "SEP 2022"]
var yValues = [3,5,6,8,9,10,11,13,15,17,16,130]

new Chart("totalRevenueGraph", {
    type: "line",
    data: {
        labels: xValues,
        datasets: [{
            data: yValues
        }]
    },
    options: {
        legend: {display:false}
    }
})