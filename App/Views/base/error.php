<div class="row pt-2 justify-content-start h-100">
    <div class="col-12 ">
        <div class="card">
            <div class="card-body">
                <div class="error-page">
                    <h2 class="headline text-warning">
                        <?php if(!is_null($error))
                        {
                            echo $error->codigo;
                        }?></h2>

                    <div class="error-content">
                        <br>

                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Atencion</h3>

                        <p>
                        <?php if(!is_null($error))
                        {
                            echo $error->error;
                        }?>
                        </p>
                    </div>
                    <!-- /.error-content -->
                </div>
                <!-- /.error-page -->
            </div>
        </div>
    </div>
</div>