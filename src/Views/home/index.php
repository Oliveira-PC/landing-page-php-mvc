<!-- SEÇÃO INICIAL: Apresentação de Alto Impacto -->
<section class="min-h-[85vh] flex items-center justify-center relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 text-center z-10">
        <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight">
            Precisão <span class="text-gold">Milimétrica.</span><br>
            Design <span class="text-cactus">Exclusivo.</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-400 mb-10 max-w-3xl mx-auto font-light">
            Transformamos suas ideias em produtos reais com tecnologia de ponta em Modelagem 3D e Gravação a Laser de alto padrão.
        </p>
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <a href="#leads" class="w-full sm:w-auto gold-gradient text-black font-bold text-lg px-10 py-4 rounded shadow-[0_0_20px_rgba(212,175,55,0.4)] hover:shadow-[0_0_30px_rgba(212,175,55,0.6)] transition duration-300">
                Iniciar Projeto
            </a>
            <a href="/catalogo/download?v=<?= time() ?>" class="w-full sm:w-auto border border-[#D4AF37] text-gold font-bold text-lg px-10 py-4 rounded hover:bg-[#D4AF37]/10 transition duration-300 flex items-center justify-center gap-2">
                Baixar Catálogo PDF
            </a>
        </div>
    </div>
</section>

<!-- SEÇÃO PORTFÓLIO: Vitrine Dinâmica -->
<section id="portfolio" class="py-12 relative min-h-[600px]">
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold mb-2">Catálogo de <span class="text-gold">Produtos</span></h2>
            <p class="text-gray-400">Selecione uma categoria abaixo para visualizar nossos trabalhos.</p>
        </div>

        <div class="flex justify-center px-4 mb-12">
            <div class="bg-glass p-2 rounded-full border border-[#D4AF37]/30 shadow-2xl flex w-full max-w-2xl justify-between overflow-hidden">
                <button onclick="carregarPortfolio('3d', this)" class="btn-filtro w-1/3 text-center py-3 md:py-4 text-xs sm:text-sm font-bold transition-all rounded-full bg-[#D4AF37]/20 text-gold shadow-[0_0_10px_rgba(212,175,55,0.2)]">
                    Impressão 3D
                </button>
                <button onclick="carregarPortfolio('laser', this)" class="btn-filtro w-1/3 text-center py-3 md:py-4 text-xs sm:text-sm font-bold transition-all rounded-full text-gray-400 hover:text-white">
                    Gravação a Laser
                </button>
                <button onclick="carregarPortfolio('sublimacao', this)" class="btn-filtro w-1/3 text-center py-3 md:py-4 text-xs sm:text-sm font-bold transition-all rounded-full text-gray-400 hover:text-white">
                    Sublimação
                </button>
            </div>
        </div>

        <div id="galeria-produtos" class="flex flex-wrap justify-center gap-6 mt-8 pb-24 md:pb-0">

        </div>
    </div>
</section>

<!-- SCRIPT DE CONSUMO DA API REST -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        carregarPortfolio('3d', document.querySelector('.btn-filtro'));
    });

    async function carregarPortfolio(slug, elementoClicado) {
        
        document.querySelectorAll('.btn-filtro').forEach(btn => {
            btn.classList.remove('bg-[#D4AF37]/20', 'text-gold', 'shadow-[0_0_10px_rgba(212,175,55,0.2)]');
            btn.classList.add('text-gray-400');
        });
        elementoClicado.classList.remove('text-gray-400');
        elementoClicado.classList.add('bg-[#D4AF37]/20', 'text-gold', 'shadow-[0_0_10px_rgba(212,175,55,0.2)]');

        const galeria = document.getElementById('galeria-produtos');
        galeria.innerHTML = '<p class="text-center text-gray-500 w-full mt-10">Buscando catálogo no servidor...</p>';

        try {
            const response = await fetch(`/api/portfolio?category_slug=${slug}`);
            
            if (response.status === 404) {
                throw new Error('Nenhum produto cadastrado nesta categoria ainda.');
            }
            if (!response.ok) {
                throw new Error('Erro ao carregar o catálogo.');
            }
            
            const result = await response.json();
            const produtos = result.data; 
            galeria.innerHTML = '';

            //Renderiza os cartões flexíveis na tela
            produtos.forEach(produto => {
                const card = document.createElement('div');
                card.className = "flex flex-col bg-[#0a0a0a] border border-gray-800 rounded-xl overflow-hidden shadow-lg w-full sm:w-[calc(50%-1.5rem)] md:w-[calc(33.333%-1.5rem)] hover:border-[#2E7D32] hover:shadow-[0_0_20px_rgba(46,125,50,0.3)] transition duration-500";
                
                card.innerHTML = `
                    <div class="h-56 overflow-hidden bg-black flex items-center justify-center relative">
                        <!-- Tag Nativa de Lazy Loading exigida pelo DET -->
                        <img src="${produto.imagemUrl}" alt="${produto.titulo}" loading="lazy" class="object-cover w-full h-full hover:scale-110 transition duration-500">
                        <div class="absolute top-3 right-3 bg-black/70 backdrop-blur text-xs font-bold px-3 py-1 rounded text-gold border border-gold/30">
                            ${produto.materialCompativel}
                        </div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-2">${produto.titulo}</h3>
                            <p class="text-sm text-gray-400 mb-6 leading-relaxed">${produto.descricao}</p>
                        </div>
                        <a href="#leads" onclick="document.querySelector('textarea[name=mensagem]').value = 'Olá! Gostaria de um orçamento para o produto: ${produto.titulo}';" class="text-center w-full block border border-gray-600 text-gray-300 font-bold text-sm px-4 py-3 rounded hover:bg-gray-800 hover:text-white transition">
                            Tenho Interesse
                        </a>
                    </div>
                `;
                galeria.appendChild(card);
            });
        } catch (error) {
            galeria.innerHTML = `<p class="text-center text-red-400 w-full mt-10">${error.message}</p>`;
        }
    }
</script>

<!-- SEÇÃO LEADS: Captura de Orçamento -->
<section id="leads" class="py-24 relative">
    <div class="max-w-3xl mx-auto px-4">

        <div class="bg-glass p-8 md:p-12 rounded-xl border border-[#2E7D32]/40 shadow-[0_0_30px_rgba(46,125,50,0.15)] relative z-10">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold mb-2">Solicite uma <span class="text-cactus">Cotação</span></h2>
                <p class="text-gray-400">Preencha os dados abaixo e entraremos em contato rapidamente.</p>
            </div>

            <form action="/api/leads" method="POST" class="space-y-6">

                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

                <input type="hidden" name="origem_secao" value="home_hero_form">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nome Completo</label>
                        <input type="text" name="nome" required class="w-full bg-black/50 border border-gray-700 rounded p-3 text-white focus:border-gold focus:ring-1 focus:ring-gold outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">WhatsApp / Telefone</label>
                        <input type="tel" name="telefone" placeholder="(11) 99999-9999" required class="w-full bg-black/50 border border-gray-700 rounded p-3 text-white focus:border-gold focus:ring-1 focus:ring-gold outline-none transition">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">O que você precisa?</label>
                    <textarea name="mensagem" rows="4" placeholder="Descreva sua ideia para Impressão 3D ou Gravação a Laser..." required class="w-full bg-black/50 border border-gray-700 rounded p-3 text-white focus:border-gold focus:ring-1 focus:ring-gold outline-none transition"></textarea>
                </div>
                
                <button type="submit" class="w-full gold-gradient text-black font-bold text-lg px-8 py-4 rounded hover:opacity-90 transition transform active:scale-95">
                    Enviar Solicitação
                </button>
            </form>
        </div>
    </div>
</section>


<a href="<?= \App\Helpers\WhatsAppHelper::getLink('duvidas') ?>" target="_blank" class="fixed bottom-6 right-6 z-50 bg-[#25D366] text-white p-4 rounded-full shadow-[0_4px_15px_rgba(37,211,102,0.4)] hover:scale-110 transition-transform duration-300 flex items-center justify-center cursor-pointer">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.031 0C5.383 0 0 5.383 0 12.031c0 2.124.553 4.195 1.604 6.012L.15 24l6.11-1.603a11.96 11.96 0 005.771 1.488h.004c6.648 0 12.031-5.383 12.031-12.031S18.68 0 12.031 0zm0 21.844c-1.802 0-3.567-.484-5.114-1.402l-.367-.217-3.8.997.997-3.801-.238-.378a9.966 9.966 0 01-1.533-5.305c0-5.503 4.478-9.981 9.981-9.981s9.981 4.478 9.981 9.981-4.478 9.981-9.981 9.981zm5.474-7.485c-.3-.15-1.776-.877-2.052-.977-.276-.1-.477-.15-.677.15-.2.3-.777.977-.952 1.177-.175.2-.35.225-.65.075-.3-.15-1.267-.467-2.412-1.488-.891-.793-1.492-1.773-1.667-2.073-.175-.3-.018-.462.132-.612.135-.135.3-.35.45-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.677-1.63-.927-2.23-.242-.582-.487-.503-.677-.512-.175-.008-.375-.008-.575-.008-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5s1.075 2.9 1.225 3.1c.15.2 2.112 3.225 5.115 4.525.715.31 1.272.495 1.708.634.717.228 1.37.195 1.884.118.577-.086 1.776-.725 2.026-1.425.25-.7.25-1.3.175-1.425-.075-.125-.275-.2-.575-.35z"/>
    </svg>
</a>