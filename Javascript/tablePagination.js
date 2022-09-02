function Getpagination() {
    const table = document.getElementById("OrdersTable")
    var SelectedPage = 1;
    var RowNumber = 0
    var RowIndex = 0
    var SelectRows = 0
    var TotalPageNumber = 0
    var FirstPage
    var SelectAmountOfRowsValue = document.getElementById("rowspicker")
    SelectAmountOfRowsValue.addEventListener("change", function(){

        // RESET SECTION 

        // Resetting number of rows in the table and the final page.
        SelectedPage = 1;
        RowNumber = 0
        // Taking the answer from the select option in the file and converting it to integer
        SelectRows = parseInt(SelectAmountOfRowsValue.options[SelectAmountOfRowsValue.selectedIndex].value)
        // Gets the total number of rows in the table
        TotalRows = (document.getElementsByTagName("tr").length -1)
        //Gets total number of pages needed
        TotalPageNumber = Math.ceil(TotalRows/SelectRows)
        console.log(TotalPageNumber)
        // Setting the pagination section as a nodelist.
        PaginationList = document.querySelectorAll(".pagination")
        DataRows = document.querySelector(".DataRows")
        // Finding the next and previous buttons
        liPaginationList = PaginationList[0].querySelectorAll("li")
        console.log(liPaginationList)
        PagButtons = document.querySelectorAll(".PagButton")
        // Converting it to an array so that slice can be used with it. Slice takes off the first and last elements, and remove removes the pagination section
        ArrPaginationList = Array.apply(null, PaginationList)
        ArrPaginationList.slice(1,-1)
        PagButtons.forEach(element => {
            element.parentNode.removeChild(element)
        });
        
        // PAGINATION SECTION
        // Gets all of the rows of the table and replaces show or hide with hide. However, if the index of the row is less than the chosen amount, then its shown. This is to show the first page as soon as a new option is selected.
        console.log(SelectRows)
        TableRows = document.querySelectorAll(".Completed, .Waiting, .Refunded")
        TableRows.forEach(function callback(value, index) {
            value.classList.remove("show", "hide")
            value.classList.add("hide")
            if (index < SelectRows) {
                value.classList.replace("hide", "show")
            }
        });

        // For every pagination page needed, it creates an li element at the bottom which acts as a selector for a new page.
        for (let i = 1; i <= TotalPageNumber; i++) {
            liTag = document.createElement("li")
            liText = document.createTextNode(i)
            liTag.appendChild(liText)
            liTag.classList.add("PagButton")
            liTag.dataset.pagination = i
            DataRows.appendChild(liTag)
        }

        //Adds active class to the first page. 
        FirstPage = document.querySelector('[data-pagination="1"]')
        FirstPage.classList.add("active")
        liPaginationList = PaginationList[0].querySelectorAll("li")
        //Adds an event listener to the non number pagination elements
        liPaginationList.forEach(element => {
            element.addEventListener("click", function(elem){
                //Stops additional event listeners from running when this is called.
                elem.stopImmediatePropagation();
                // Gets the information from data-pagination, to check what type of button it is.
                ButtonName = element.dataset.pagination
                console.log(SelectedPage)
                if (ButtonName === "start") {
                    // Doesn't do anything if it is already at the first element
                    if (SelectedPage == 1) {
                        return
                    }
                    ButtonName = 1
                } else if (ButtonName === "prev") {
                    if (SelectedPage == 1) {
                        return
                    }
                    ButtonName = parseInt(SelectedPage) - 1
                } else if (ButtonName === "next") {
                    if (SelectedPage == TotalPageNumber) {
                        return
                    }
                    ButtonName = parseInt(SelectedPage) + 1
                } else if (ButtonName === "end") {
                    if (SelectedPage == TotalPageNumber) {
                        return
                    }
                    ButtonName = TotalPageNumber
                }
                //Allows just clicking the numbers to work.
                SelectedPage = ButtonName
                liPaginationList = PaginationList[0].querySelectorAll("li")
                liPaginationList.forEach(element => {
                    element.classList.remove("active")
                    //Adds active to the class if their index is same as the selected page
                    if (element.dataset.pagination == SelectedPage) {
                        element.classList.add("active")
                    }
                });
                //Add limit pagging here
                for (let i = 0; i < TotalRows; i++) {
                    if (i >= SelectRows * SelectedPage || i <  SelectRows * SelectedPage - SelectRows) {
                        TableRows[i].classList.remove("show", "hide")
                        TableRows[i].classList.add("hide")
                    } else {
                        TableRows[i].classList.replace("hide", "show")
                    }
                    
                }  
            });
        });


    });
    // when the page is loaded, calls a change so the pagination can start.
    var changeEvent = new Event("change")
    SelectAmountOfRowsValue.dispatchEvent(changeEvent)
}

Getpagination();