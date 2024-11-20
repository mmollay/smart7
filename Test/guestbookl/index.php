<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Material Design Gästebuch mit CKEditor 5</title>
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- CKEditor 5 über CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Eigener Stil -->
    <style>
        .gaestebuch-eintrag { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .gaestebuch-eintrag:last-child { border-bottom: none; }
        .gaestebuch-datum { font-size: 0.8em; color: grey; }
        .ck-editor__editable { min-height: 200px; }
        .delete-entry { color: red; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="header">Gästebuch</h2>
    <form id="gaestebuch-form">
        <div class="input-field">
            <input id="name" name="name" type="text" class="validate" required>
            <label for="name">Name</label>
        </div>
        <div class="input-field">
            <div id="nachricht" class="materialize-textarea"></div>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">Eintragen
            <i class="material-icons right">send</i>
        </button>
    </form>

    <h3>Bisherige Einträge:</h3>
    <div id="gaestebuch-eintraege" class="gaestebuch-eintraege">
        <!-- Einträge werden hier angezeigt -->
    </div>

    <!-- Modal Struktur -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <h4>Fehlermeldung</h4>
            <p id="errorMessage"></p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Schließen</a>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // Initialisiere das Modal
    $('.modal').modal();

    // Initialisiere CKEditor
    let editor;
    ClassicEditor
        .create(document.querySelector('#nachricht'))
        .then(newEditor => {
            editor = newEditor;
        })
        .catch(error => {
            console.error(error);
        });

    // Formular-Submit-Funktion
    $("#gaestebuch-form").submit(function(event){
        event.preventDefault();

        // Aktualisiere die Textarea mit den Daten aus CKEditor
        const nachricht = editor.getData();

        $.ajax({
            type: "POST",
            url: "submit_entry.php",
            data: {
                name: $("#name").val(),
                nachricht: nachricht
            },
            success: function(response){
                if(response.startsWith("Error:")) {
                    // Setze Fehlermeldung und öffne das Modal
                    $("#errorMessage").text(response.substring(6));
                    $('#errorModal').modal('open');
                } else {
                    // Aktualisiere die Einträge und setze das Formular zurück
                    $("#gaestebuch-eintraege").html(response);
                    editor.setData('');
                    $("#name").val('');
                }
            }
        });
    });

    // Lade die Einträge beim ersten Laden der Seite
    loadEntries();

    // Event-Handler für Lösch-Links
    $(document).on('click', '.delete-entry', function(e) {
        e.preventDefault();
        var timestamp = $(this).data('timestamp');
        var token = $(this).data('token');
        deleteEntry(timestamp, token);
    });

    function deleteEntry(timestamp, token) {
    
        $.ajax({
            type: "POST",
            url: "delete_entry.php",
            data: { timestamp: timestamp, token: token },
            success: function(response) {
                if(response === "Success") {
                    // Aktualisiere die Einträge
                    loadEntries();
                } else {
                    // Fehlerbehandlung
                    console.error("Fehler beim Löschen des Eintrags");
                }
            }
        });
    }

    function loadEntries() {
        $.ajax({
            url: "submit_entry.php",
            success: function(data) {
                $("#gaestebuch-eintraege").html(data);
            }
        });
    }
    
    function deleteEntry(timestamp, token) {
    if (!confirm("Bist du sicher, dass du diesen Eintrag löschen möchtest?")) {
        return;
    }

    $.ajax({
        type: "POST",
        url: "delete_entry.php",
        data: { timestamp: timestamp, token: token },
        success: function(response) {
            $("#gaestebuch-eintraege").html(response);
        }
    });
}
    
    
});
</script>

<!-- Materialize JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>
