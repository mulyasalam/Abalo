let items;
function myFunction(){
    v3=2;

}
let v3=1;
myFunction();
console.log(v3);
import {add} from 'mathjs';


window.onload = function() {
    items = [];
    loadCart();
    //showItems(items);
}

function addProduct(article){
    //if item not in basket yet
    if(!items.find(item => item.id === article.id) ){
        items.push(article);
        console.log(items);
        showItems(items);
    }
}

function removeProduct(article){
    items = items.filter(item => item !== article);
    console.log(items);
}

let table = document.createElement('table');
table.style = 'width: 100%;';
document.getElementById("myBasket").appendChild(table);

function showItems() {
    // Clear the table
    table.innerHTML = '';

    // Create table headers
    let headers = ['Name', 'Price', 'Action'];
    let thead = document.createElement('thead');
    let headerRow = document.createElement('tr');

    headers.forEach(header => {
        let th = document.createElement('th');
        th.textContent = header;
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    table.appendChild(thead);

    let sum = 0;

    // Iterate over the items array
    for (let i = 0; i < items.length; i++) {
        // Create a new row and cells
        let row = document.createElement('tr');
        //row.style = 'border-bottom: dashed 1px grey; padding: 10px;';

        let cell = document.createElement('td');
        cell.style = 'background-color: lightgrey; font-color:black;';
        //cell.classList.add('text-black');

        let cell3 = document.createElement('td');
        cell3.style = 'background-color: lightgrey;';
        let pr = items[i].ab_price/100
        cell3.textContent = pr.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
        cell3.classList.add('text-black');
        sum= add(sum,pr);

        let cell2 = document.createElement('td');
        let removeButton = document.createElement('button');
        removeButton.textContent = 'remove';

        cell2.onclick = function() {
            removeItem(1, items[i].id);
            removeProduct(items[i]);
            showItems();
        }

        cell2.style = 'background-color: darkred;';
        cell2.classList.add('text-white');


        cell2.appendChild(removeButton);



        // Set the text of the cell to the item
        let item = items[i];
        cell.textContent = item.ab_name; // Assuming 'ab_name' is a property of the item

        // Add the cells to the row
        row.appendChild(cell);
        row.appendChild(cell3);
        row.appendChild(cell2);

        // Add the row to the table
        table.appendChild(row);

    }

    let footer = document.createElement('tfoot'); // Create a new row

    let foot1 = document.createElement('td');// Create a new cell
    foot1.textContent = 'Total';

    let foot2 = document.createElement('td');
    foot2.textContent = sum.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';

    let foot3 = document.createElement('td');
    foot3.style = 'background-color: darkred;';

    let RemoveAllButton = document.createElement('button');
    RemoveAllButton.textContent = 'Remove All';
    RemoveAllButton.onclick = function() {
        items.forEach(function (item){
            removeItem(1, item.id);
            removeProduct(item);
        });
        showItems();
    }

    foot3.appendChild(RemoveAllButton);

    footer.appendChild(foot1);
    footer.appendChild(foot2);
    footer.appendChild(foot3);

    table.appendChild(footer);


}

window.updateCart = function (id) {

    if(!items.some(item => item.id === id)) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/api/shoppingcart", true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        console.log(id);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify({article_id: id}));

        xhr.onload = function () {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);
                console.log(response);
                addProduct(response);
                loadCart();
            }
        }
    }
}


function removeItem(shoppingCartId, articleId){
    var xhr = new XMLHttpRequest();
    xhr.open("DELETE", "/api/shoppingcart/" + shoppingCartId + "/articles/" + articleId, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({article_id: articleId, shoppingcartid: shoppingCartId}));

    xhr.onload = function () {
        if (xhr.status === 200) {
            // let response = JSON.parse(xhr.responseText);
            console.log(xhr.responseText);
            items = items.filter(item => item !== xhr.responseText);
            showItems();

        }
    }
}

function loadCart(){
    var xhr = new XMLHttpRequest();
    xhr.open("get", "/api/shoppingcart", true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    xhr.send();

    xhr.onload = function () {
        if (xhr.status == 200) {
            let response = JSON.parse(xhr.responseText);
            console.log(response);
            items = response;
            showItems();
        }
    }
}
