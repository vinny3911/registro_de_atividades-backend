<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calendário de Atividades</title>

        <!-- Bootstrap + JQuery -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

        <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- ESTILO -->
        <script src="{{ asset('js/index.global.min.js') }}"></script> <!-- BIBLIOTECA FULLCALENDAR -->
        <script src="{{ asset('js/core/locales-all.global.min.js') }}"></script> <!-- TRADUÇÃO DA BIBLIOTECA FULLCALENDAR -->
        <script src="{{ asset('js/calendar.js') }}"></script> <!-- CORPO DO CALENDARIO -->
        <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">

    </head>

    <body class="bg-light">

        <div id='calendar'></div>

        <div class="calendar-actions">
            <button id="novaAtividadeBtn">Nova Atividade</button>
            <button id="todayBtn">Hoje</button>
        </div>

        <script>
            document.getElementById('novaAtividadeBtn').addEventListener('click', () => {
                window.location.href = "{{ route('atividades.create') }}";
            });
        </script>

    </body>
</html>