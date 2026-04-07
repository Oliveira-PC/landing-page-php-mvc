# JC Personalizados - Landing Page 3D & Laser 🚀

Uma Landing Page de alta performance voltada à conversão de vendas para serviços de **Impressão 3D, Gravação a Laser e Sublimação**. Construída do zero utilizando arquitetura **MVC com PHP puro**, orientada pelas práticas recomendadas do PHP-FIG (PSR-4/PSR-12), sem a dependência de frameworks pesados.

## 🌟 Destaques da Arquitetura
- **Padrão MVC e Autoloader PSR-4:** Código modularizado em Controllers, Models, Views e Helpers.
- **Performance-First:** Layout dinâmico construído com CSS Flexbox responsivo, carregamento de imagens nativo em WebP (`loading="lazy"`) e efeito *Glassmorphism* em menus.
- **Máquina de Vendas (WhatsApp API):** Captação de Leads no Banco de Dados com redirecionamento contínuo gerando links mágicos e pré-preenchidos para o WhatsApp.
- **Portfólio Assíncrono:** Consumo de catálogo RESTful API interna (Retorno JSON camelCase) usando *Fetch API* do Javascript para filtragem sem recarregar a página.
- **Segurança Bancária:** Integração rigorosa com banco de dados usando **PDO (Prepared Statements)** contra SQL Injection e validação CSRF nos formulários (Proteção de Sessão).

## 🛠️ Tecnologias Utilizadas
- **Back-end:** PHP 8.2+ (Strict Types)
- **Front-end:** HTML5, CSS3 (Tailwind classes), JavaScript (ES6+), CSS Flexbox.
- **Banco de Dados:** MySQL/MariaDB (InnoDB, Normalizado em 3NF).
- **Servidor Web:** Apache (com reescrita via `.htaccess`).

---

## ⚙️ Como Instalar e Configurar o Projeto

Siga os passos abaixo para rodar este projeto no seu servidor local (XAMPP/WAMP) ou em produção:

### 1. Clonar o Repositório
```bash
git clone https://github.com/Oliveira-PC/landing-page-php-mvc.git

2. Configurar o Banco de Dados (DB)
Este sistema exige o cadastro de categorias e serviços no banco de dados para que a API do Portfólio funcione na tela.
Crie um banco de dados no seu MySQL chamado jcpersonalizados (com collation utf8mb4_unicode_ci).
Importe as tabelas SQL da arquitetura. O sistema possui as seguintes tabelas em Terceira Forma Normal:
categorias
servicos
leads (onde os contatos preenchidos no site são salvos)
Conecte sua aplicação: Vá até o arquivo responsável pela conexão (/src/Core/Database.php ou arquivo de configuração correspondente) e atualize as credenciais:

$host = 'localhost';
$dbname = 'jcpersonalizados';
$username = 'root'; // Seu usuário
$password = '';     // Sua senha

3. Configurar o seu Número de WhatsApp
O sistema centraliza o seu número de atendimento em um único arquivo de configuração para facilitar futuras alterações, servindo como base para todos os botões e formulários do site.
Navegue até a pasta /config/ e abra o arquivo whatsapp.php.
Altere a variável para o número da sua empresa (inclua o código do país DDI + DDD + Número. Apenas números).

return [
    'numero_destino' => '5511999999999' // Substitua pelo seu número
];

4. Configurar o Catálogo em PDF
O projeto possui uma rota segura e sem cache para o download de portfólios (/catalogo/download). Para que ele não exiba a página de Erro 404 de "Documento Indisponível":
Crie ou adicione o seu arquivo com o nome exato de catalogo.pdf.
Coloque-o dentro do caminho físico /public/assets/docs/.

--------------------------------------------------------------------------------

🛡️ Roteamento (Aviso Apache)
Atenção: Como o sistema utiliza um Router PHP nativo, todas as requisições web devem ser direcionadas ao arquivo index.php localizado na pasta /public/. O projeto já conta com o arquivo .htaccess configurado. Certifique-se de que o módulo mod_rewrite do seu Apache está ativo no servidor.
