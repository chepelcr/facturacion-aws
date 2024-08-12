<?php $modulos = getModulos() ?>

<div class="row">

    <!-- Recorrer los modulos -->
    <?php foreach ($modulos as $modulo) : ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">
                            <?= ucwords(str_replace('_', ' ', $modulo->nombre_modulo)) ?>
                        </h3>
                        <i class=" fa <?php echo $modulo->icono ?>"></i>
                    </div>
                </div>

                <div class="card-body text-center">
                    <!-- Boton para obtener el modulo de empresa -->
                    <button type="button" onclick="cargar_inicio_modulo('<?php echo $modulo->nombre_modulo ?>')" class="btn btn-dark">
                        Entrar
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Imprimir archivo de prueba -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">
                        Prueba
                    </h3>
                    <i class=" fa fa-cogs"></i>
                </div>
            </div>

            <div class="card-body text-center">
                <div class="row">
                    <div class="col-md-8">
                        <div>
                            <div>
                                <label for="txtPdfFile">PDF File URL:</label>
                                <input type="text" name="txtPdfFile" id="txtPdfFile" value="https://biller.jcampos.me/documentos/pdf/374" />
                            </div>
                            <div>
                                <label for="lstPrinters">Printers:</label>
                                <select name="lstPrinters" id="lstPrinters" onchange="showSelectedPrinterInfo();"></select>
                            </div>
                            <div>
                                <label for="lstPrinterTrays">Supported Trays:</label>
                                <select name="lstPrinterTrays" id="lstPrinterTrays"></select>
                            </div>
                            <div>
                                <label for="lstPrinterPapers">Supported Papers:</label>
                                <select name="lstPrinterPapers" id="lstPrinterPapers"></select>
                            </div>
                            <div>
                                <label for="lstPrintRotation">Print Rotation (Clockwise):</label>
                                <select name="lstPrintRotation" id="lstPrintRotation">
                                    <option>None</option>
                                    <option>Rot90</option>
                                    <option>Rot180</option>
                                    <option>Rot270</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div>
                                <label for="txtPagesRange">Pages Range: [e.g. 1,2,3,10-15]</label>
                                <input type="text" id="txtPagesRange">
                            </div>
                            <div>
                                <div>
                                    <label><input id="chkPrintInReverseOrder" type="checkbox" value="">Print In Reverse Order?</label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <label><input id="chkPrintAnnotations" type="checkbox" value="">Print Annotations? <span><em>Windows Only</em></span></label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <label><input id="chkPrintAsGrayscale" type="checkbox" value="">Print As Grayscale? <span><em>Windows Only</em></span></label>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <button type="button" onclick="print()" class="btn btn-dark">
                    Entrar
                </button>
            </div>
        </div>
    </div>
</div>