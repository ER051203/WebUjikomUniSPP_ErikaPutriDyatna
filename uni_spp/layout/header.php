<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNI SPP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-color: #0F3460; --secondary-color: #16213E; --accent: #E94560; }
        body { background-color: #F1F3F6; font-family: 'Segoe UI', sans-serif; }
        .bg-primary-custom { background-color: var(--primary-color) !important; color: white; }
        .text-primary-custom { color: var(--primary-color) !important; }
        #wrapper { display: flex; min-height: 100vh; }
        #sidebar-wrapper { width: 250px; background-color: var(--secondary-color); color: white; }
        .sidebar-heading { padding: 1.5rem; font-size: 1.2rem; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .list-group-item-action { background-color: transparent; color: #ccc; border: none; padding: 15px 20px; transition: 0.3s; }
        .list-group-item-action:hover, .list-group-item-action.active { background-color: var(--primary-color); color: white; border-left: 4px solid var(--accent); }
    </style>
</head>