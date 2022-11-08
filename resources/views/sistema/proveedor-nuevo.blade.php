@extends("plantilla")
@section('titulo', $titulo)
@section('scripts')
<script>
    globalId = '<?php echo isset($proveedor->idproveedor) && $proveedor->idproveedor > 0 ? $proveedor->idproveedor : 0; ?>';
    <?php $globalId = isset($proveedor->idproveedor) ? $proveedor->idproveedor : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/proveedores">Proveedor</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/proveedor/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
    function fsalir() {
        location.href = "/admin/proveedores";
    }
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id="msg"></div>
<div class="panel-body">
    <form id="form1" method="POST">
        <div class="row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="form-group col-6">
                <label>Nombre: *</label>
                <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
            </div>
            <div class="form-group col-6">
                <label>Domicilio: *</label>
                <input type="text" id="txDomicilio" name="txtDomicilio" class="form-control" value="" required>
            </div>
            <div class="form-group col-6">
                <label>Cuit: *</label>
                <input type="number" id="txtCuit" name="txtCuit" class="form-control" value="" required>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
            <div class="form-group col-6">
                <label>Rubro: *</label>
                <select id="lstRubro" name="lstRubro" class="form-control selectpicker" required>
                    <option value="" disabled selected>Seleccionar</option>
                    @foreach($aRubros as $rubro)
                    @if($rubro->idrubro == $proveedor->fk_idrubro)
                    <option selected value="{{ $rubro->idrubro }}">{{ $rubro->nombre }}</option>
                    @else
                    <option value="{{ $rubro->idrubro }}">{{ $rubro->nombre }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

        </div>


    </form>
    <script>
        $("#form1").validate();

        function guardar() {
            if ($("#form1").valid()) {
                modificado = false;
                form1.submit();
            } else {
                $("#modalGuardar").modal('toggle');
                msgShow("Corrija los errores e intente nuevamente.", "danger");
                return false;
            }

        }

        function eliminar() {
            $.ajax({
                type: "GET",
                url: "{{ asset('admin/proveedor/eliminar') }}",
                data: {
                    id: globalId
                },
                async: true,
                dataType: "json",
                success: function(data) {
                    if (data.err == 0) {
                        msgShow(data.mensaje, "success");
                        $("#btnEnviar").hide();
                        $("#btnEliminar").hide();
                        $('#mdlEliminar').modal('toggle');
                    } else {
                        msgShow(data.mensaje, "danger");
                        $('#mdlEliminar').modal('toggle');
                    }
                }
            });
        }
    </script>
    @endsection