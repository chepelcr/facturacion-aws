<!-- Modal para loguearse en el sistema -->
<div class="modal fade" id="modal_login" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-transparent">
            <div class="modal-body bg-olive login-page" style="max-height: 75vh;">
                <div class="login-box">
                    <?= view('seguridad/login/login')?>

                    <?= view('seguridad/login/olvido')?>
                    
                    <?= view('seguridad/login/cambio_contrasenia')?>
                </div>
                <!-- /.login-box -->
            </div>
        </div>
    </div>
</div>