<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Películas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">FORMULARIO SUBIR PELÍCULAS</h1>
        
        <form action="subpeliculas.php" method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="nombre_pelicula" class="block text-sm font-medium text-gray-700">Nombre de la película:</label>
                <input type="text" name="nombre_pelicula" id="nombre_pelicula"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción de la película:</label>
                <textarea name="descripcion" id="descripcion" rows="4"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>
            
            <div>
                <label for="caratula" class="block text-sm font-medium text-gray-700">Carátula:</label>
                <input type="file" name="caratula" id="caratula"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Subir Película
            </button>
        </form>
    </div>
</body>
</html>