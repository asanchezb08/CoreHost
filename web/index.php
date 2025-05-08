<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoreHost - Servidors Ràpids, Segurs i Confiables</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
    <!-- Afegir Font Awesome per les icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
        body {
            margin: 0;
            padding: 0;
        }
        .navbar {
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 0;
            padding: 1rem 0;
        }
        .hero-section {
            padding-top: 1.5rem;
            margin-top: 0;
        }
        .container {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        .header-container {
            margin-top: 1rem !important;
            margin-bottom: 2rem !important;
        }
        nav ul {
            margin: 0 !important;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="navbar">
        <div class="container">
            <div class="header-container">
                <div class="header-title">
                    <h1>
                        <span class="logo">
                            <i class="fas fa-server"></i>
                            CoreHost
                        </span>
                    </h1>
                    <div class="header-subtitle">Servidors Ràpids, Segurs i Confiables</div>
                </div>
                <div class="action-buttons">
                    <a href="panell/login.php" class="btn btn-outline">
                        <i class="fas fa-sign-in-alt btn-icon"></i>Iniciar Sessió
                    </a>
                    <a href="panell/registro.php" class="btn btn-primary">
                        <i class="fas fa-user-plus btn-icon"></i>Registrar-se
                    </a>
                </div>
            </div>
            <nav>
                <ul style="display: flex; gap: 1.5rem; list-style: none; padding: 0;">
                    <li><a href="#inicio" style="color: var(--text-light); text-decoration: none; font-weight: 500;">Inici</a></li>
                    <li><a href="#serveis" style="color: var(--text-light); text-decoration: none; font-weight: 500;">Serveis</a></li>
                    <li><a href="#configurador" style="color: var(--text-light); text-decoration: none; font-weight: 500;">Plans</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="inicio" class="hero-section container">
            <div class="header-container" style="margin-top: 1rem; margin-bottom: 2rem;">
                <div class="header-title">
                    <h1>Servidors potents i confiables per al teu negoci</h1>
                    <div class="header-subtitle" style="margin-top: 1rem; margin-bottom: 1.5rem; max-width: 600px;">
                        Servidors d'alt rendiment amb recursos dedicats i preus competitius. Totalment escalables segons les teves necessitats.
                    </div>
                    <div class="action-buttons">
                        <a href="#configurador" class="btn btn-primary">
                            <i class="fas fa-cogs btn-icon"></i>Configurar servidor
                        </a>
                    </div>
                    <div style="display: flex; gap: 1.5rem; margin-top: 1.5rem;">
                        <span style="display: flex; align-items: center; color: var(--text-light); font-size: 0.875rem;">
                            <i class="fas fa-check-circle" style="color: var(--success); margin-right: 0.5rem;"></i>99.9% Uptime
                        </span>
                        <span style="display: flex; align-items: center; color: var(--text-light); font-size: 0.875rem;">
                            <i class="fas fa-check-circle" style="color: var(--success); margin-right: 0.5rem;"></i>Recursos dedicats
                        </span>
                        <span style="display: flex; align-items: center; color: var(--text-light); font-size: 0.875rem;">
                            <i class="fas fa-check-circle" style="color: var(--success); margin-right: 0.5rem;"></i>Escalabilitat total
                        </span>
                    </div>
                </div>
                <div>
                    <img src="img.jpg" alt="Il·lustració de servidor" style="border-radius: var(--radius); box-shadow: var(--shadow-lg); max-width: 100%; height: auto;">
                </div>
            </div>

            <!-- Servicios -->
            <section id="serveis" style="margin-bottom: 3rem;">
                <h2 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 1rem;">Els nostres Serveis</h2>
                <p style="color: var(--text-light); margin-bottom: 2rem;">Oferim servidors d'alta qualitat per satisfer totes les teves necessitats.</p>
                
                <div class="vm-grid">
                    <!-- Entorn LAMP -->
                    <div class="vm-card">
                        <div class="vm-header">
                            <div class="vm-info">
                                <h3 class="vm-hostname">
                                    <i class="fas fa-terminal btn-icon" style="color: var(--primary);"></i>
                                    Entorn LAMP preconfigurat
                                </h3>
                            </div>
                            <span class="vm-status status-completado">Disponible</span>
                        </div>
                        <div class="vm-body">
                            <p>Els nostres servidors compten amb un entorn LAMP ja preconfigurat i llest per ser utilitzat.</p>
                            <div class="vm-specs">
                                <div class="spec-item">
                                    <span class="spec-label">Linux</span>
                                    <span class="spec-value"><i class="fab fa-linux"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Apache</span>
                                    <span class="spec-value"><i class="fas fa-server"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">MySQL</span>
                                    <span class="spec-value"><i class="fas fa-database"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">PHP</span>
                                    <span class="spec-value"><i class="fab fa-php"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Autoinstal·lador CMS -->
                    <div class="vm-card">
                        <div class="vm-header">
                            <div class="vm-info">
                                <h3 class="vm-hostname">
                                    <i class="fas fa-download btn-icon" style="color: var(--primary);"></i>
                                    Autoinstal·lador WordPress
                                </h3>
                            </div>
                            <span class="vm-status status-completado">Disponible</span>
                        </div>
                        <div class="vm-body">
                            <p>Instal·la WordPress amb un sol clic i comença a crear el teu lloc web.</p>
                            <div class="vm-specs">
                                <div class="spec-item">
                                    <span class="spec-label">WordPress</span>
                                    <span class="spec-value"><i class="fab fa-wordpress"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Fàcil</span>
                                    <span class="spec-value"><i class="fas fa-magic"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Ràpid</span>
                                    <span class="spec-value"><i class="fas fa-bolt"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Actualitzat</span>
                                    <span class="spec-value"><i class="fas fa-sync"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Escalabilitat -->
                    <div class="vm-card">
                        <div class="vm-header">
                            <div class="vm-info">
                                <h3 class="vm-hostname">
                                    <i class="fas fa-expand-arrows-alt btn-icon" style="color: var(--primary);"></i>
                                    Escalabilitat
                                </h3>
                            </div>
                            <span class="vm-status status-completado">Disponible</span>
                        </div>
                        <div class="vm-body">
                            <p>Amplia els recursos del teu servidor segons creixin les teves necessitats.</p>
                            <div class="vm-specs">
                                <div class="spec-item">
                                    <span class="spec-label">CPU</span>
                                    <span class="spec-value"><i class="fas fa-microchip"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">RAM</span>
                                    <span class="spec-value"><i class="fas fa-memory"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Disc</span>
                                    <span class="spec-value"><i class="fas fa-hdd"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Disponibilitat -->
                    <div class="vm-card">
                        <div class="vm-header">
                            <div class="vm-info">
                                <h3 class="vm-hostname">
                                    <i class="fas fa-shield-alt btn-icon" style="color: var(--primary);"></i>
                                    Disponibilitat
                                </h3>
                            </div>
                            <span class="vm-status status-completado">Garantida</span>
                        </div>
                        <div class="vm-body">
                            <p>Garantim un 99.9% de temps d'activitat per als teus serveis.</p>
                            <div class="vm-specs">
                                <div class="spec-item">
                                    <span class="spec-label">Uptime</span>
                                    <span class="spec-value">99.9%</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Monitorització</span>
                                    <span class="spec-value">24/7</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Suport</span>
                                    <span class="spec-value">Premium</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Atenció al client 24/7 -->
                    <div class="vm-card">
                        <div class="vm-header">
                            <div class="vm-info">
                                <h3 class="vm-hostname">
                                    <i class="fas fa-headset btn-icon" style="color: var(--primary);"></i>
                                    Atenció al client 24/7
                                </h3>
                            </div>
                            <span class="vm-status status-completado">Disponible</span>
                        </div>
                        <div class="vm-body">
                            <p>El nostre equip d'atenció al client està disponible 24 hores al dia, 7 dies a la setmana.</p>
                            <div class="vm-specs">
                                <div class="spec-item">
                                    <span class="spec-label">Horari</span>
                                    <span class="spec-value">24/7</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Email</span>
                                    <span class="spec-value"><i class="fas fa-envelope"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Telèfon</span>
                                    <span class="spec-value"><i class="fas fa-phone"></i></span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Chat</span>
                                    <span class="spec-value"><i class="fas fa-comments"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Servidors Ubicats a Catalunya -->
                    <div class="vm-card">
                        <div class="vm-header">
                            <div class="vm-info">
                                <h3 class="vm-hostname">
                                    <i class="fas fa-map-marker-alt btn-icon" style="color: var(--primary);"></i>
                                    Servidors Ubicats a Catalunya
                                </h3>
                            </div>
                            <span class="vm-status status-completado">Garantit</span>
                        </div>
                        <div class="vm-body">
                            <p>Tots els nostres servidors estan físicament ubicats en centres de dades a Catalunya.</p>
                            <div class="vm-specs">
                                <div class="spec-item">
                                    <span class="spec-label">Ubicació</span>
                                    <span class="spec-value">Catalunya</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Latència</span>
                                    <span class="spec-value">Baixa</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Seguretat</span>
                                    <span class="spec-value">Alta</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Normativa</span>
                                    <span class="spec-value">EU/RGPD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Configurador del servidor -->
            <section id="configurador" style="margin-bottom: 3rem;">
                <div class="vm-card">
                    <div class="vm-header">
                        <div class="vm-info">
                            <h3 class="vm-hostname">
                                <i class="fas fa-cogs btn-icon" style="color: var(--primary);"></i>
                                Configura el teu Servidor del Futur
                            </h3>
                            <p class="vm-ip">Dissenya un servidor a la teva mida amb tecnologia d'avantguarda i descobreix el seu preu a l'instant.</p>
                        </div>
                    </div>
                    <div class="vm-body">
                        <form class="form">
                            <div class="form-group">
                                <label for="plan-type">Tipus de Pla</label>
                                <select id="plan-type" class="form-control">
                                    <option value="basic" data-cpu="2" data-ram="4" data-price="20">Bàsic: 2 Nuclis, 4GB RAM - 20€</option>
                                    <option value="medium" data-cpu="4" data-ram="6" data-price="30">Mitjà: 4 Nuclis, 6GB RAM - 30€</option>
                                    <option value="advanced" data-cpu="6" data-ram="8" data-price="40">Avançat: 6 Nuclis, 8GB RAM - 40€</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="storage">Emmagatzematge</label>
                                <select id="storage" class="form-control">
                                    <option value="50" data-price="5">50 GB HDD - 5€</option>
                                    <option value="100" data-price="10">100 GB HDD - 10€</option>
                                    <option value="150" data-price="15">150 GB HDD - 15€</option>
                                    <option value="200" data-price="20">200 GB HDD - 20€</option>
                                </select>
                            </div>
                            
                            <div class="form-divider">Resum de la teva Configuració</div>
                            
                            <div class="vm-specs" style="grid-column: span 2; margin-top: 1rem;">
                                <div class="spec-item">
                                    <span class="spec-label">Processador</span>
                                    <span id="summary-cpu" class="spec-value">2 Nuclis</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Memòria RAM</span>
                                    <span id="summary-ram" class="spec-value">4 GB</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Emmagatzematge</span>
                                    <span id="summary-storage" class="spec-value">50 GB HDD</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Preu</span>
                                    <span id="summary-price" class="spec-value" style="color: var(--primary); font-weight: 700;">25€</span>
                                </div>
                            </div>
                            
                            <div class="form-submit" style="margin-top: 1.5rem;">
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </section>
    </main>

    <footer style="background-color: var(--dark); color: var(--light); padding: 2rem 0;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                <div style="max-width: 300px; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem;">CoreHost</h3>
                    <p style="color: var(--text-light);">Servidors d'alt rendiment amb recursos dedicats i preus competitius. Totalment escalables segons les teves necessitats.</p>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem;">Enllaços</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--text-light); text-decoration: none;">Inici</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--text-light); text-decoration: none;">Serveis</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--text-light); text-decoration: none;">Plans</a></li>
                        <li style="margin-bottom: 0.5rem;"><a href="#" style="color: var(--text-light); text-decoration: none;">Contacte</a></li>
                    </ul>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem;">Contacte</h3>
                    <p style="color: var(--text-light); margin-bottom: 0.5rem;">
                        <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i>info@corehost.cat
                    </p>
                    <p style="color: var(--text-light); margin-bottom: 0.5rem;">
                        <i class="fas fa-phone" style="margin-right: 0.5rem;"></i>+34 93 123 45 67
                    </p>
                    <p style="color: var(--text-light);">
                        <i class="fas fa-map-marker-alt" style="margin-right: 0.5rem;"></i>Barcelona, Catalunya
                    </p>
                </div>
            </div>
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); text-align: center; color: var(--text-light);">
                <p>&copy; 2025 CoreHost. Tots els drets reservats.</p>
            </div>
        </div>
    </footer>

    <script>
        // Actualitzar resum i preu al canviar el tipus de pla
        document.getElementById('plan-type').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const cpu = selectedOption.getAttribute('data-cpu');
            const ram = selectedOption.getAttribute('data-ram');
            const planPrice = parseInt(selectedOption.getAttribute('data-price'));

            document.getElementById('summary-cpu').textContent = cpu + ' Nuclis';
            document.getElementById('summary-ram').textContent = ram + ' GB';

            updatePrice(planPrice);
        });

        // Actualitzar resum i preu al canviar l'emmagatzematge
        document.getElementById('storage').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const storage = selectedOption.value + ' GB HDD';
            const storagePrice = parseInt(selectedOption.getAttribute('data-price'));

            document.getElementById('summary-storage').textContent = storage;

            updatePrice(null, storagePrice);
        });

        // Calcular el preu total
        function updatePrice(planPrice = null, storagePrice = null) {
            const planType = document.getElementById('plan-type');
            const selectedPlan = planType.options[planType.selectedIndex];
            const basePrice = planPrice !== null ? planPrice : parseInt(selectedPlan.getAttribute('data-price'));

            const storageType = document.getElementById('storage');
            const selectedStorage = storageType.options[storageType.selectedIndex];
            const additionalStoragePrice = storagePrice !== null ? storagePrice : parseInt(selectedStorage.getAttribute('data-price'));

            const totalPrice = basePrice + additionalStoragePrice;
            document.getElementById('summary-price').textContent = totalPrice + '€';
        }

        // Inicialitzar el preu
        updatePrice();
    </script>
</body>
</html>
