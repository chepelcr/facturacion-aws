/*var clientPrinters = null;
var _this = this;*/

function printIframeContent(iframeId) {
    var iframe = document.getElementById(iframeId);
    if (iframe) {
        var iframeWindow = iframe.contentWindow || iframe.contentDocument.defaultView;
        iframeWindow.focus();
        iframeWindow.print();
    } else {
        console.error("Iframe not found");
    }
}

function imprimirTiquete() {
    printIframeContent('ticketIframe');
}

//WebSocket settings
/*JSPM.JSPrintManager.auto_reconnect = true;
JSPM.JSPrintManager.start();
JSPM.JSPrintManager.WS.onStatusChanged = function () {
    if (jspmWSStatus()) {
        //get client installed printers
        JSPM.JSPrintManager.getPrintersInfo().then(function (printersList) {
            clientPrinters = printersList;
            var options = '';
            for (var i = 0; i < clientPrinters.length; i++) {
                options += '<option>' + clientPrinters[i].name + '</option>';
            }
            $('#lstPrinters').html(options);
            _this.showSelectedPrinterInfo();
        });
    }
};*/

//Check JSPM WebSocket status
/*function jspmWSStatus() {
    if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
        return true;
    else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
        alert('JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm');
        return false;
    }
    else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
        alert('JSPM has blocked this website!');
        return false;
    }
}

//Do printing...
function print() {
    if (jspmWSStatus()) {

        //Create a ClientPrintJob
        var cpj = new JSPM.ClientPrintJob();

        //Set Printer info
        var myPrinter = new JSPM.InstalledPrinter($('#lstPrinters').val());
        myPrinter.paperName = $('#lstPrinterPapers').val();
        myPrinter.trayName = $('#lstPrinterTrays').val();

        cpj.clientPrinter = myPrinter;

        //Set PDF file
        var my_file = new JSPM.PrintFilePDF($('#txtPdfFile').val(), JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
        my_file.printRotation = JSPM.PrintRotation[$('#lstPrintRotation').val()];
        my_file.printRange = $('#txtPagesRange').val();
        my_file.printAnnotations = $('#chkPrintAnnotations').prop('checked');
        my_file.printAsGrayscale = $('#chkPrintAsGrayscale').prop('checked');
        my_file.printInReverseOrder = $('#chkPrintInReverseOrder').prop('checked');

        cpj.files.push(my_file);

        //Send print job to printer!
        cpj.sendToClient();

    }
}

function showSelectedPrinterInfo() {
    // get selected printer index
    var idx = $("#lstPrinters")[0].selectedIndex;
    // get supported trays
    var options = '';
    for (var i = 0; i < clientPrinters[idx].trays.length; i++) {
        options += '<option>' + clientPrinters[idx].trays[i] + '</option>';
    }
    $('#lstPrinterTrays').html(options);
    // get supported papers
    options = '';
    for (var i = 0; i < clientPrinters[idx].papers.length; i++) {
        options += '<option>' + clientPrinters[idx].papers[i] + '</option>';
    }
    $('#lstPrinterPapers').html(options);
}*/