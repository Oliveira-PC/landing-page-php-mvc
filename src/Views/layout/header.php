<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JC Personalizados | Impressão 3D & Gravação a Laser</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Regras Visuais */
        body {
            background-color: #000000;
            /* Textura de Fibra de Carbono sutil */
            background-image: radial-gradient(#222 1px, transparent 1px);
            background-size: 10px 10px;
            color: #ffffff;
            scroll-behavior: smooth;
        }
        
        /* Efeito de Vidro */
        .bg-glass {
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        /* Identidade Visual - Dourado e Verde Cacto */
        .text-gold { color: #D4AF37; }
        .text-cactus { color: #2E7D32; }
        .gold-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #AA8222 100%);
        }
    </style>
</head>
<body class="antialiased font-sans flex flex-col min-h-screen">

    <header class="fixed w-full top-0 z-50 bg-glass border-b border-[#D4AF37]/30 transition-all">

        <div class="max-w-7xl mx-auto px-4 h-28 flex items-center justify-center md:justify-between">
            
            <a href="/" class="flex items-center transform hover:scale-105 transition duration-300">
                <img src="/assets/img/LogoNome.webp" alt="Logotipo JC Personalizados 3D e Laser" class="h-16 md:h-20 w-auto object-contain">
            </a>
            
            <!-- Menu de Navegação (Fica escondido no mobile e aparece no desktop) -->
            <nav class="hidden md:flex items-center space-x-8 text-sm uppercase tracking-wide">
                <a href="#servicos" class="hover:text-gold transition duration-300">Serviços</a>
                <a href="#portfolio" class="hover:text-gold transition duration-300">Portfólio</a>
                <a href="#leads" class="gold-gradient text-black px-6 py-2 rounded font-bold hover:scale-105 transition transform">
                    Fazer Orçamento
                </a>
            </nav>
        </div>
    </header>
    
    <main class="flex-grow pt-28">