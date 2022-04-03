//Menu Div
var menu = document.getElementById("menu");

//Content Divs
//Get All Content Divs
var contentHome = document.getElementById("home-content");
var contentOrders = document.getElementById("orders-content");
var contentBooks = document.getElementById("books-content");

//Menu
//Get Menu Buttons
var menuHome = document.getElementById("menu-home");
var menuOrders = document.getElementById("menu-orders");
var menuBooks = document.getElementById("menu-books");

//User Operations
//User Operation Buttons
var ordersCancel = document.getElementById("orders-cancel");
var ordersChange = document.getElementById("orders-change");
var booksOrder = document.getElementById("books-order");

//Functions For Easy Coding
//Change Button Syles (Accepts String change/dont And Button Element)
function button_change_style(change, button) 
{
    switch(change) {
        case "change":
            button.style.transform = "scale(1.2)";
            button.style.borderBottom = "1vh solid #A239CA";
            break;
        case "dont":
            button.style.transform = "scale(1)";
            button.style.borderBottom = "0vh solid #E7DFDD";
            break;
        default:
            break;
    }
}

//Hide Content Divs (Accepts Strings)
function hide_content_divs(div1, div2, div3) 
{
    contentHome.style.display = div1;
    contentOrders.style.display = div2;
    contentBooks.style.display = div3;
}

//Hide And Show Selector Divs Depending On Main Selector
function uo_change_selectors(div1, div2, div3)
{
    document.getElementById("uo-change-book").style.display = div1;
    document.getElementById("uo-change-payment").style.display = div2;
    document.getElementById("uo-change-delivery").style.display = div3;
}

//Setup Of User Operations Divs, On Click, Display/Hide Divs (ID Of Div, ID Of Button Of Display Div, ID Of Button Of Hide Div)
function uo_divs_setup(iddiv, idshow, idclose, idcontentdiv)
{
    var div = document.getElementById(iddiv);

    var show_button = document.getElementById(idshow);
    var close_button = document.getElementById(idclose);

    show_button.onclick = function()
    {
        div.style.display = "block";

        //Hide Menu
        menu.style.display = "none";
        
        //Hide Coresponding Content Div
        idcontentdiv.style.display = "none";
    }

    close_button.onclick = function() 
    {
        div.style.display = "none";

        //Show Menu
        menu.style.display = "block";
        
        //Show Coresponding Content Div
        idcontentdiv.style.display = "block";
    }
}

//Main Stuff
//On Click (Menu Buttons)
menuHome.onclick = function() {
    //Change Styles
    button_change_style("change", this);
    button_change_style("dont", menuOrders);
    button_change_style("dont", menuBooks);

    //Hide Divs
    hide_content_divs("block", "none", "none");
}

menuOrders.onclick = function() {
    //Change Styles
    button_change_style("change", this);
    button_change_style("dont", menuHome);
    button_change_style("dont", menuBooks);

    //Hide Divs
    hide_content_divs("none", "block", "none");
}

menuBooks.onclick = function() {
    //Change Styles
    button_change_style("change", this);
    button_change_style("dont", menuOrders);
    button_change_style("dont", menuHome);

    //Hide Divs
    hide_content_divs("none", "none", "block");
}

//User Operations Divs Setup
//UO-Cancel
uo_divs_setup("orders-operations-delete", "orders-cancel", "orders-cancel-close", contentOrders);
//UO-Change
uo_divs_setup("orders-operations-change", "orders-change", "orders-change-close", contentOrders);
//UO-Order
uo_divs_setup("books-operations-order", "books-order", "books-order-close", contentBooks);

//UO-Change-Main Selector
//Modify Selector, Show Chosen Option, Hide Others
document.getElementById("change_selector").onchange = function() {
    var i = this.value;
    switch(i)
    {
        case "Change Book":
            uo_change_selectors("block", "none", "none");
            break;
        case "Change Payment":
            uo_change_selectors("none", "block", "none");
            break;
        case "Change Delivery":
            uo_change_selectors("none", "none", "block");
            break;
        default:
            break;
    }
}

