class mergeSort {

    // This class takes in table data, creates a 2d array which basically consists of key and value pairs (Couldn't use mapping as there is no easy way to split the map). It then performs a merge sort on the data

    // Initialises private attributes
    #column;
    #table;
    #rows;
    #direction;

    // Class constructor sets the column number that the sort is meant to be done on, as well as the table and initialises the rows
    constructor(column, direction) {
        this.#column = column;
        this.#direction = direction;
        this.#table = document.getElementById("EventTable");
        this.#rows = this.#table.rows;

    }

    // Getters
    getColumn() {
        return this.#column;
    }

    getRows() {
        return this.#rows;
    }

    getDirection() {
        return this.#direction;
    }

    // Gets total number of rows. Subtracts one to not include headers
    getNoOfRows() {
        let AmountOfRows = this.getRows().length - 1;
        return AmountOfRows;
    }

    // Takes in a number, and returns the entire row that corresponds to that number
    getRowFromRows(num) {
        let row = this.getRows();
        let temp = row[num];
        return temp
    }

    // Creates a 2d array of the full column by iterating through the total number of rows (minus the header) and for each row, forming key (numbers going up to number of rows) and value (the table data) pairs.
    createFullArr() {
        let Arr = []
        for (let i = 1; i <= this.getNoOfRows(); i++) {
            var temp = this.getRowFromRows(i).getElementsByTagName("TD")[this.getColumn()];
            let temparr = [i, temp];
            Arr.push(temparr)
        };
        console.log(Arr)
        // After the array for the column is formed, it starts the recursive process of splitting the arrays
        return this.sliceAndSort(Arr)
    }

    // Uses recursion to split the main array into arrays of size 1,continuously halving them from the midpoint and then calls mergeArrays which puts them back together in the correct order
    sliceAndSort(columnArr) {
        var firstArr = []
        var secondArr = []
        if (columnArr.length <= 1) {
            // Returns arrays of length one, which gets stored in firstArr or secondArr variable - base case
            return columnArr
        }
        let midpoint = Math.trunc(columnArr.length / 2);
        firstArr = this.sliceAndSort(columnArr.slice(0, midpoint))
        secondArr = this.sliceAndSort(columnArr.slice(midpoint))
        return this.mergeArrays(firstArr, secondArr)
    }

    // If the innerHTML isn't a number, it checks what direction the sort is meant to be in, compares the values inside the arrays and then removes the value from the smaller/bigger array and returns it along with the new arrays
    compareTwoElementsNaN(leftArr, rightArr) {
        if (this.getDirection() === "asc") {
            // Converting to lowercase so uppercase values dont skew the results due to them having higher ascii values
            if (leftArr[0][1].innerHTML.toLowerCase() < rightArr[0][1].innerHTML.toLowerCase()) {
                //.shift is used similarly to .pop in that it removes the first element of the array, and also returns the value
                var removedElement = leftArr.shift()
            } else {
                var removedElement = rightArr.shift()
            }
        } else {
            if (leftArr[0][1].innerHTML.toLowerCase() > rightArr[0][1].innerHTML.toLowerCase()) {
                var removedElement = leftArr.shift()
            } else {
                var removedElement = rightArr.shift()
            }
        }
        return [removedElement, leftArr, rightArr]
    }

    compareTwoElementsIaN(leftArr, rightArr) {
        if (this.getDirection() === "asc") {
            // Similar to above except instead of comparing text, its comparing numbers. If above function was used for all, the number 11 would be less than the number 6 due to lower ascii values
            if (Number(leftArr[0][1].innerHTML) < Number(rightArr[0][1].innerHTML)) {
                var removedElement = leftArr.shift()
            } else {
                var removedElement = rightArr.shift()
            }
        } else {
            if (Number(leftArr[0][1].innerHTML) > Number(rightArr[0][1].innerHTML)) {
                var removedElement = leftArr.shift()
            } else {
                var removedElement = rightArr.shift()
            }
        }
        return [removedElement, leftArr, rightArr]
    }

    //Takes in 2 sorted arrays, checks the data inside them and orders them to form a bigger array
    mergeArrays(leftArr, rightArr) {
        let sortedArr = [] // the sorted items will go here
        var removedElementArr = []
        while (leftArr.length != 0 && rightArr.length != 0) {
            removedElementArr = []
            if (isNaN(leftArr[0][1].innerHTML)) {
                removedElementArr = this.compareTwoElementsNaN(leftArr, rightArr)
                sortedArr.push(removedElementArr[0])
                leftArr = removedElementArr[1]
                rightArr = removedElementArr[2]
            } else {
                removedElementArr = this.compareTwoElementsIaN(leftArr, rightArr)
                sortedArr.push(removedElementArr[0])
                leftArr = removedElementArr[1]
                rightArr = removedElementArr[2]
            }  
        }
        // Use spread operators to create a new array, which combines the sorted array and whatever is left from either the left or right array
        return [...sortedArr, ...leftArr, ...rightArr]
    }

    

    // This function recieves the array given by createFullArr, and changes the order of the rows depending on the array inputted
    reorderElements(arr) {
        let keyArr = []
        for (let i = 0; i < arr.length; i++) {
            keyArr.push(arr[i][0])
        }
        let idList = []
        // gets the table data that is associated with the value in array, and gets the entire row and puts it into an array
        keyArr.forEach(element => {
            let temp = this.getRows()[element].getElementsByTagName("TD")[0]
            idList.push(temp.parentNode)
        });
        // Goes through the idList and appends them. Appending brings the value to the bottom of the stack so once all of the data has been appended it will be in the right oder
        idList.forEach(element => {
            element.parentNode.appendChild(element)
        });
    }
}

// This is the class that is called by the main program. It takes in the column(id value) and direction (asc or desc)
export class initiateSort {

    constructor(columnNum, direction) {
        const newSort = new mergeSort(columnNum, direction);
        const sortColumn = newSort.createFullArr();
        newSort.reorderElements(sortColumn);
    }
}







