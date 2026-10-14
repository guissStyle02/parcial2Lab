<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNACH - Gestión de Documentos</title>
    <!-- FontAwesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <!-- Encabezado Principal -->
    <header class="navbar">
        <div class="logo-container">
        <i class="fa-solid fa-file-invoice logo-icon"></i> 

            <div>
                <h1>UNACH</h1>
                <span>Sistema Institucional de Administración Escolar</span>

            </div>
        </div>
        <div class="user-info">
            <i class="fa-solid fa-bell"></i>
            <i class="fa-solid fa-circle-user avatar"></i>
        </div>
    </header>

    <div class="app-layout">
        
        <!-- Menú Lateral (Sidebar para Escritorio) -->
        <aside class="sidebar">
            <button class="nav-btn active" id="btnVerTabla">
                <i class="fa-solid fa-file-lines"></i>
                <span>Documentos</span>
            </button>
            <button class="nav-btn" id="btnVerFormulario">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Nuevo Documento</span>
            </button>
        </aside>

        <!-- Contenido Principal -->
        <main class="main-content">

            <!-- VISTA 1: DASHBOARD / TABLA DE DOCUMENTOS -->
            <section id="vistaDashboard" class="view-section">
                <div class="card-table">
                    <div class="table-header">
                        <h2><i class="fa-solid fa-list"></i> Listado de Documentos</h2>
                        <button class="btn-primary-small" id="btnNuevoDoc">
                            <i class="fa-solid fa-plus"></i> Nuevo Documento
                        </button>
                    </div>

                    <!-- Buscador y Filtros -->
                    <div class="filter-box">
                        <input type="text" id="buscarTexto" placeholder="Buscar por No. de oficio, asunto, remitente...">
                        <select id="filtroEstatus">
                            <option value="">Todos los Estatus</option>
                            <option value="Recibido">Recibido</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Atendido">Atendido</option>
                        </select>
                    </div>


                    <!-- Tabla de Resultados -->
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No. Oficio</th>
                                    <th>Fecha</th>
                                    <th>Asunto</th>
                                    <th>Remitente</th>
                                    <th>Destinatario</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaDocumentosBody">
                                <!-- Se cargará dinámicamente con PHP/jQuery -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- VISTA 2: FORMULARIO DE REGISTRO -->
            <section id="vistaFormulario" class="view-section hidden">
                <div class="card-form">
                    <div class="card-header">
                        <i class="fa-solid fa-file-signature"></i>
                        <h2>Registrar Documento</h2>
                    </div>

                    <form id="formDocumento" enctype="multipart/form-data">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="num_oficio">No. de Oficio *</label>
                                <input type="text" id="num_oficio" name="num_oficio" placeholder="Ej. 0452/2026" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha">Fecha *</label>
                                <input type="date" id="fecha" name="fecha" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="asunto">Asunto *</label>
                            <textarea id="asunto" name="asunto" rows="2" placeholder="Descripción breve del asunto" required></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="remitente">Remitente *</label>
                                <input type="text" id="remitente" name="remitente" placeholder="Nombre o dependencia" required>
                            </div>
                            <div class="form-group">
                                <label for="destinatario">Destinatario *</label>
                                <input type="text" id="destinatario" name="destinatario" placeholder="Nombre o área" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estatus">Estatus *</label>
                            <select id="estatus" name="estatus">
                                <option value="Recibido">Recibido</option>
                                <option value="En proceso">En proceso</option>
                                <option value="Atendido">Atendido</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Documento (foto o PDF) *</label>
                            <div class="upload-options">
                                <label class="upload-box">
                                    <i class="fa-solid fa-camera icon-upload"></i>
                                    <span>Tomar foto del documento</span>
                                    <input type="file" id="inputFoto" name="archivo" accept="image/*" capture="environment" hidden>
                                </label>

                                <label class="upload-box">
                                    <i class="fa-solid fa-file-arrow-up icon-upload"></i>
                                    <span>Seleccionar archivo PDF</span>
                                    <input type="file" id="inputPdf" name="archivo" accept="application/pdf" hidden>
                                </label>
                            </div>
                            <small id="nombreArchivoSeleccionado" style="color:#01377D; font-weight:bold; display:block; margin-top:8px;"></small>
                        </div>

                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar Documento
                        </button>
                    </form>
                </div>
            </section>

        </main>
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>