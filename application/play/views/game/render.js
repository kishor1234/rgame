let {remote, ipcRenderer} = require("electron");
// console.log(process.versions.electron);

const {PosPrinter} = remote.require("electron-pos-printer");
// const {PosPrinter} = require("electron-pos-printer"); //dont work in production (??)
const dialog = remote.dialog;
const path = require("path");
let WIN = remote.getCurrentWindow();

//console.log(path.join(__dirname, '/logo.webp'));
//let webContents = remote.getCurrentWebContents();
//let printers = webContents.getPrinters(); //list the printers
//var PrinterName;
//var width = "170px";
//printers.map((item, index) => {
//    //write in the screen the printers for choose
//    if (item.isDefault) {
//        PrinterName = item.name;
//    }
//});

function printPos(jsonData) {

    var ticketArray = jsonData.ticket;
    var d = [];
    var children = [];
    for (let index in ticketArray) {
        var ticketData = ticketArray[index];
        children = children.concat(PrintData(ticketData));



    }
    //console.log(children);
    ipcRenderer.send('todo:add', JSON.stringify(children));

//    
}
function PrintData(ticketData) {
    return  [
        {
            type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table
            value: "||---",
            style: `text-align:left;`,
            css: {"font-size": "12px"},
        },
        {
            type: 'image',
            path: 'src/icon.ico', // file path
            position: 'center', // position of image: 'left' | 'center' | 'right'
            width: '50px', // width of image in px; default: auto
            height: '50px', // width of image in px; default: 50 or '50px'
        },
        {
            type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
            value: ticketData.ticket,
            css: {
                "font-size": "10px",
                "font-family": "sans-serif",
                "text-align": "left",
            },
        },
        {
            type: "barCode", // Do you think the result is ugly? Me too. Try use an image instead...
            value: ticketData.barcode,
            height: 25,
            width: 1,
            displayValue: false, // Display value below barcode
            fontsize: 25,
            position: 'left',
            style: 'margin: 0px 20px',
            css: {
                "font-size": "15px",
                "font-family": "sans-serif",
                "text-align": "left",
            },

        },
        {
            type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
            value: ticketData.barcode,
            css: {
                "font-size": "12px",
                "font-family": "sans-serif",
                "text-align": "center",
            },
        },

        {
            type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table
            value: "---||",
            style: `text-align:right;`,
            css: {"font-size": "12px"},
        },
    ];
}
function rePrint(lasttsn) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText != "false") {
                var jsonData = JSON.parse(this.responseText);
                const ticketArray = jsonData.ticket;
                var d = [];
                var children = [];
                for (let index in ticketArray) {
                    var ticketData = ticketArray[index];

                    //d.push(data);
                    children = children.concat(PrintData(ticketData));
                    //d = [...data];

                }
                //d.push(children);
                ipcRenderer.send('todo:add', JSON.stringify(children));



            }
        }
    };
    xhttp.open("POST", api_url + "/?r=posTicket", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({"utrno": lasttsn}));

}


function printWinRecipt(data) {
    //console.log(data);
    var jsonData = JSON.parse(data);
    var children = [];
    if (jsonData.status === "1")
    {
        const data = [
            {
                type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table
                value: "||---",
                style: `text-align:left;`,
                css: {"font-size": "12px"},
            },
            {
                type: 'image',
                path: 'src/icon.ico', // file path
                position: 'center', // position of image: 'left' | 'center' | 'right'
                width: '50px', // width of image in px; default: auto
                height: '50px', // width of image in px; default: 50 or '50px'
            },
            {
                type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                value: jsonData["0"]["recip"],
                css: {
                    "font-size": "10px",
                    "font-family": "sans-serif",
                    "text-align": "left",
                },
            },
            {
                type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table
                value: "---||",
                style: `text-align:right;`,
                css: {"font-size": "12px"},
            },
        ];
//        const options = {
//            preview: false, // Preview in window or print
//            width: width, //  width of content body
//            margin: "0 0 0 0", // margin of content body
//            copies: 1, // Number of copies to print
//            printerName: PrinterName, // printerName: string, check it at webContent.getPrinters()
//            timeOutPerLine: 400,
//            silent: true,
//        };


        const d = children.concat(data);
//        children = children.concat(data);

        ipcRenderer.send('todo:add', JSON.stringify(d));
    }
}
function printPlayedRecipt(jsonData) {
    //console.log(data);

    var children = [];
    if (jsonData.status === "1")
    {
        const ticketArray = jsonData.data;
        var d = [];
        var children = [];
        for (let index in ticketArray) {
            const data = [
                {
                    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table
                    value: "||---",
                    style: `text-align:left;`,
                    css: {"font-size": "12px"},
                },
                {
                    type: 'image',
                    path: 'src/icon.ico', // file path
                    position: 'center', // position of image: 'left' | 'center' | 'right'
                    width: '50px', // width of image in px; default: auto
                    height: '50px', // width of image in px; default: 50 or '50px'
                },
                {
                    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table'
                    value: ticketArray[index],
                    css: {
                        "font-size": "10px",
                        "font-family": "sans-serif",
                        "text-align": "left",
                    },
                },
                {
                    type: "text", // 'text' | 'barCode' | 'qrCode' | 'image' | 'table
                    value: "---||",
                    style: `text-align:right;`,
                    css: {"font-size": "12px"},
                },
            ];
            children = children.concat(data);
        }




        ipcRenderer.send('todo:add', JSON.stringify(children));
    }
}


ipcRenderer.on('register:bet', (event, bet) => {
    //console.log(bet);
    switch (bet) {
        case "bet":
            betreg();
            break;
        case "fclaim":
            fclaim();
            break;
        case "up":
            pageup();
            break;
        case "down":
            pagedown();
            break;
        default:
            break;
    }

});

function quit()
{
    ipcRenderer.send('todo:add', "quit");
}

async function Confirm(msg) {
    var retur = 1;
    let options = {};
    options.buttons = ["Yes", "No"];
    options.message = msg;
    retur = await dialog.showMessageBox(WIN, options);
    return retur;
}
function Alert(msg) {
    let options = {};
    options.buttons = ["Ok"];
    options.message = msg;
    dialog.showMessageBox(WIN, options, (res, checked) => {
//        console.log(res);
//        console.log(checked);
        if (res === 0)
            WIN.destroy();
    });
}
