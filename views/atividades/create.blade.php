<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cadastrar Atividade</title>

    <!-- Bootstrap + JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    
    </head>

    <body class="bg-light">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 m-0">Criação de atividade esportiva</h1>
                <a href="{{ route('atividades.index') }}" class="btn btn-outline-secondary">X</a>
            </div>

            {{-- Alerta de conflito vindo do Controller --}}
            @if ($errors->has('conflito'))
                <div style="color:red; font-weight:bold;">
                    {{ $errors->first('conflito') }}
                </div>
            @endif

            {{-- Alerta com outros erros de validação --}}
            @if ($errors->any() && !$errors->has('conflito'))
                <div class="alert alert-warning">
                    Corrija os campos destacados abaixo.
                </div>
            @endif
            
            <div class="card shadow-sm">
                <div class="card-body">
                    
                    <form id="form-atividade" action="{{ route('atividades.store') }}" method="POST" novalidate>
                        @csrf <!-- Proteção obrigatória contra CSRF -->
                        
                        <div class="row g-3"> 

                            <div class="col-12">
                                <label for="nome" class="form-label">Evento </label>
                                <input 
                                    type="text"
                                    id="nome"
                                    name="nome"
                                    class="form-control @error('nome') is-invalid @enderror"
                                    value="{{ old('nome') }}" 
                                    required
                                >
                                @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label for="descricao" class="form-label">Descrição </label>
                                <textarea
                                    id="descricao"
                                    name="descricao"
                                    class="form-control @error('descricao') is-invalid @enderror"
                                    rows="3"
                                >{{ old('descricao') }}</textarea>
                                @error('descricao') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="data" class="form-label">De: </label>
                                <input 
                                    type="text"
                                    id="data"
                                    name="data"
                                    class="form-control @error('data') is-invalid @enderror"
                                    value="{{ old('data') }}" 
                                    required
                                >
                                @error('data') <div class="invalid-feedback">{{ @message }}</div> @enderror
                            </div>

                            <div class="col-md-8">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="nao_repete">
                                    <label class="form-check-label" for="nao_repete" class="form-label">Não se repete</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="repete" checked>
                                    <label class="form-check-label" for="repete" class="form-label">Repetir</label>                                    
                                </div>

                            </div>

                            <div class="col-md-2">
                                <label for="hora_inicio" class="form-label">Início: </label>
                                <input 
                                    type="time" 
                                    name="hora_inicio" 
                                    id="hora_inicio"
                                    class="form-control @error('hora_inicio') is-invalid @enderror"
                                    value="{{ old('hora_inicio') }}"
                                    min="06:00" max="22:00"
                                    required
                                >
                                @error('hora_inicio') <div class="invalid-feedback">{{ @message }}</div> @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="hora_termino" class="form-label">Término: </label>
                                <input 
                                    type="time" 
                                    name="hora_termino" 
                                    id="hora_termino"
                                    class="form-control @error('hora_termino') is-invalid @enderror"
                                    value="{{ old('hora_termino') }}"
                                    min="06:00" max="22:00"
                                    required
                                >
                                @error('hora_termino') <div class="invalid-feedback">{{ @message }}</div> @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="recorrencia" class="form-label">
                                    <span>Intervalo de semanas:</span>
                                    <span id="valor_recorrencia" class="text-muted">{{ old('recorrencia', 2) }}</span>
                                </label>

                                <input 
                                    type="range" 
                                    id="recorrencia" 
                                    name="recorrencia"
                                    class="form-range @error('recorrencia') is-invalid @enderror"
                                    min="2" max="20"
                                    value="{{ old('recorrencia', 2) }}" 
                                >
                            </div>
                            
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </div> 
                        
                       
                        
                    </form>
                </div>
            </div>
        </div>  
        
        <script>
            $(function (){

                const $chkRepetir = $('#repete');
                const $chkNaoRepetir = $('#nao_repete');
                const $valorRecorrencia = $('#valor_recorrencia');
                const $range = $('#recorrencia');

                // Definir o idioma padrão para PT-BR
                $.datepicker.regional['pt-BR'] = {
                    closeText: 'Fechar',
                    prevText: '&#x3c;Anterior',
                    nextText: 'Pr&oacute;ximo&#x3e;',
                    currentText: 'Hoje',
                    monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                    'Jul','Ago','Set','Out','Nov','Dez'],
                    dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                    dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                    weekHeader: 'Sm',
                    dateFormat: 'dd/mm/yy',
                    firstDay: 0,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''};
                $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

                // Formata a data exibida no input
                $('#data').datepicker({
                    dateFormat: "dd 'de' MM 'de' yy",
                    changeMonth: true,
                    changeYear: true,
                    showAnim: "fadeIn",
                });

                // Transforma a data no formato ISO para mandar para o Controller
                $('#form-atividade').on('submit', function (){
                    const valor = $('#data').datepicker('getDate');
                    if (valor) {
                        const iso = valor.toISOString().split('T')[0];
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'data',
                            value: iso
                        }).appendTo(this);
                    }
                });

                // Atualiza o valor da label em relação ao range
                $range.on('input', function () {
                    $valorRecorrencia.text($(this).val());
                });
                
                // Quando marcar Não se repete
                $chkNaoRepetir.on('change', function() {
                    if (this.checked) {
                        $chkRepetir.prop('checked', false);
                        $range.prop('disabled', true);
                        $valorRecorrencia.text('-');
                    } else {
                        $range.prop('disabled', false);
                        $valorRecorrencia.text($range.val());
                    }
                });

                // Quando marcar Repetir
                $chkRepetir.on('change', function () {
                    if (this.checked) {
                        $chkNaoRepetir.prop('checked', false);
                        $range.prop('disabled', false);
                        $valorRecorrencia.text($range.val());
                    }
                });                

                // Validação de UX no cliente (não substitui a validação no Controller!)
                $('#form-atividade').on('submit', function (e) {
                    const $inicio = $('#hora_inicio');
                    const $termino = $('#hora_termino');
               
                    const inicio = $inicio.val();
                    const termino = $termino.val();

                    $inicio.removeClass('is-invalid');
                    $termino.removeClass('is-invalid');

                    if (!inicio || !termino) {
                        if (!inicio) {
                            $inicio.addClass('is-invalid');
                        }
                        if (!termino) {
                            $termino.addClass('is-invalid');
                        }
                        e.preventDefault();
                        return;
                    }
                    
                    if (termino <= inicio) {
                        $termino.addClass('is-invalid');

                        if ($termino.next('.invalid-feedback').length === 0) {
                            $termino.after('<div class="invalid-feedback">A hora de término deve ser depois do início.</div>');
                        }
                        e.preventDefault();
                        return;
                    }

                    if (inicio < '06:00' || termino > '22:00') {
                        if (inicio  < '06:00') $inicio.addClass('is-invalid');
                        if (termino > '22:00') $termino.addClass('is-invalid');
                        e.preventDefault();
                    } 
                    
                    $('#hora_termino', '#hora_inicio').on('input', function (){
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    })
                });

            });
            
        </script>
    </body>
</html>