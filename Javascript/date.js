//Making sure that the date of birth is before the current date
export function GetCurrentDate() {
    var today = new Date();
    var date = today.getDate();
    var month = today.getMonth()+1;
    var year = today.getFullYear();
    if(date < 10){
    date = '0'+date
    } 
    if(month < 10){
    month = '0'+month
    } 
    today = year+'-'+month+'-'+date;
    return today;
}
