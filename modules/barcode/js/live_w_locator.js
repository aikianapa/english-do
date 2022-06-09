$.fn.barcode = function() {
    var lastResult = null;

    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: this    // Or '#yourElement' (optional)
        },
        constraints: {
            width: 800,
            height: 600,
            facingMode: "environment",
        },
        decoder: {
            readers: ["ean_reader"]
        },
        locator: {
            patchSize: "large",
            halfSample: true
        },
        numOfWorkers: 4,
        frequency: 10,
        lastResult: null
    }, function (err) {
        if (err) {
            console.log(err);
            return
        }
        console.log("Initialization finished. Ready to start");
        Quagga.start();
    });


    if (Quagga.ready !== undefined) {
        return;
    }
    Quagga.ready = true;

    Quagga.onProcessed(function (result) {
        var drawingCtx = Quagga.canvas.ctx.overlay,
            drawingCanvas = Quagga.canvas.dom.overlay;

        if (result) {
            if (result.boxes) {
                drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                result.boxes.filter(function (box) {
                    return box !== result.box;
                }).forEach(function (box) {
                    Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
                });
            }

            if (result.box) {
                Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
            }

            if (result.codeResult && result.codeResult.code) {
                Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
            }
        }
    });

    Quagga.onDetected(function(result) {
            var code = result.codeResult.code;
            if (lastResult !== code && ( code.substr(0,3) == "357" ||  code.substr(0,3) == "123")) {
                Quagga.stop();
                lastResult = code;
                wbapp.get("/form/visits/scan?card=" + code,{},function(data){
                    $(document).trigger('mod.barcode.scan',data)
                });
                setTimeout(function () { lastResult = null;},1000);
            }
    });


};
