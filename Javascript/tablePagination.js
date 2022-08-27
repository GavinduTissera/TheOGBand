 /*					PAGINATION 
- on change max rows select options fade out all rows gt option value mx = 5
- append pagination list as per numbers of rows / max rows option (20row/5= 4pages )
- each pagination li on click -> fade out all tr gt max rows * li num and (5*pagenum 2 = 10 rows)
- fade out all tr lt max rows * li num - max rows ((5*pagenum 2 = 10) - 5)
- fade in all tr between (maxRows*PageNum) and (maxRows*pageNum)- MaxRows 
*/
function Getpagination() {
    const table = document.getElementById("OrdersTable")
    var FinalPage = 1;
    var RowNumber = 0
    var SelectRows = 0
    var PageNumber = 0
    var NewArrPagList = []
    var SelectAmountOfRowsValue = document.getElementById("rowspicker")
    SelectAmountOfRowsValue.addEventListener("change", function(){
        // Resetting number of rows in the table and the final page.
        FinalPage = 1;
        RowNumber = 0
        // Taking the answer from the select option in the file and converting it to integer
        SelectRows = parseInt(SelectAmountOfRowsValue.options[SelectAmountOfRowsValue.selectedIndex].value)
        // Gets the total number of rows in the table
        TotalRows = (document.getElementsByTagName("tr").length -1)
        //Gets total number of pages needed
        PageNumber = Math.ceil(TotalRows/SelectRows)
        console.log(PageNumber)
        // Setting the pagination section as a nodelist.
        PaginationList = document.querySelectorAll(".pagination")
        // Finding the next and previous buttons
        liPaginationList = PaginationList[0].querySelectorAll("li")
        // Converting it to an array so that slice can be used with it. Slice takes off the first and last elements, and remove removes the pagination section
        ArrPaginationList = Array.apply(null, PaginationList)
        ArrPaginationList.slice(1,-1)
        // PaginationList[0].parentNode.removeChild(PaginationList[0])
        TableRows = document.querySelectorAll(".Completed, .Waiting, .Refunded")
        TableRows.forEach(function callback(value, index) {
            value.classList.remove("show", "hide")
            value.classList.add("hide")
            if (index < SelectRows) {
                value.classList.replace("hide", "show")
            }
        });

        for (let i = 1; i <= PageNumber; i++) {
            PaginationNext = document.querySelector(".pagination #prev")
            liTag = document.createElement("li")
            liText = document.createTextNode(i)
            liTag.appendChild(liText)
            liTag.classList.add("PagButton")
            PaginationNext.appendChild(liTag)
        }



    });
}

Getpagination();