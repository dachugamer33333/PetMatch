<?php
    require '../Controller/config.php';
    session_start();
    $config=new Usuario;



?>



<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <div class="text-4xl font-bold">PETMATCH</div>
            <div class="flex items-center space-x-4">
                <i class="fas fa-bell"></i>
                <i class="fas fa-comment-dots relative">
                    <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1">1</span>
                </i>
                <div class="flex items-center space-x-2">
                    <span>User</span>
                    <i class="fas fa-user-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" placeholder="Buscar" class="w-full p-2 border rounded">
        </div>

        <!-- Navigation Tabs -->
        <div class="flex space-x-4 mb-4">
            <a href="#" class="text-blue-500 border-b-2 border-blue-500">Adopción</a>
            <a href="#" class="text-gray-500">Asociaciones</a>
            <a href="#" class="text-gray-500">Reportes</a>
            <select class="border rounded p-2">
                <option>Estados</option>
            </select>
        </div>

        <!-- Main Content -->
        <div class="flex space-x-4">
            <!-- Left Column -->
            <div class="w-1/3 space-y-4">
                <?php

                    $config->pb($conn)

                ?>
                <div class="p-4 bg-white rounded shadow flex items-center space-x-4">
                    <div class="bg-green-200 rounded-full w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-user text-green-600"></i>
                    </div>
                    <div>
                        <div class="font-bold">Jasmin rosalba</div>
                        <div>Ya no puedo tener a mi perro me mudare por cuestiones de trabajo</div>
                    </div>
                </div>
                <div class="p-4 bg-white rounded shadow flex items-center space-x-4">
                    <div class="bg-red-200 rounded-full w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-user text-red-600"></i>
                    </div>
                    <div>
                        <div class="font-bold">Juan Lopex</div>
                        <div>Mi loro esta siendo atacado constantemente por mi perro ya no puedo tenerlo</div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="w-2/3 space-y-4">
                <div class="p-4 bg-white rounded shadow">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-yellow-200 rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-user text-yellow-600"></i>
                        </div>
                        <div>
                            <div class="font-bold">Jesus Martines taboada</div>
                            <div>Doy a mi gato en adopcion porque no puedo tenerlo debido a que tengo problemas economicos y me gustaria darle una mejor vida</div>
                        </div>
                    </div>
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <i class="fas fa-image text-gray-500 text-4xl"></i>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <input type="text" placeholder="Comenta..." class="w-full p-2 border rounded">
                </div>
            </div>
        </div>
    </div>
</body>
</html>