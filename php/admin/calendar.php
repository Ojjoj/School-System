<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="modal fade" id="my_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Modal Title</h2>
                    <button class="btn-close" type="button" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">Modal Body Content</div>
                <div class="modal-footer">Modal Body Footer</div>
            </div>
        </div>
    </div>

    <div>
        <a href="#" data-toggle="modal" data-target="#my_modal">Open Modal</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
