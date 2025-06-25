<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkContent;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class WorkContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear directorio de imágenes si no existe
        if (!Storage::disk('public')->exists('images')) {
            Storage::disk('public')->makeDirectory('images');
        }

        // Sección Hero
        WorkContent::saveContent('hero', 'title', 'Bienvenidos a Nuestra Empresa', 'text', 1);
        WorkContent::saveContent('hero', 'subtitle', 'Soluciones innovadoras para tu negocio', 'text', 2);
        WorkContent::saveContent('hero', 'description', 'Ofrecemos servicios de alta calidad con tecnología de vanguardia para impulsar el crecimiento de tu empresa.', 'text', 3);
        WorkContent::saveContent('hero', 'cta_text', 'Conoce Nuestros Servicios', 'text', 4);
        WorkContent::saveContent('hero', 'cta_link', '/servicios', 'link', 5);
        WorkContent::saveContent('hero', 'background_image', 'storage/images/hero-bg.svg', 'image', 6);

        // Sección Proyectos
        WorkContent::saveContent('projects', 'title', 'Nuestros Proyectos Destacados', 'text', 1);
        WorkContent::saveContent('projects', 'subtitle', 'Trabajos que hablan por sí mismos', 'text', 2);

        // Proyecto 1
        WorkContent::saveContent('project_1', 'title', 'Sistema de Gestión Empresarial', 'text', 1);
        WorkContent::saveContent('project_1', 'description', 'Desarrollo de una plataforma completa para la gestión integral de empresas, incluyendo inventarios, ventas y reportes.', 'text', 2);
        WorkContent::saveContent('project_1', 'technologies', 'Laravel, Vue.js, MySQL, Tailwind CSS', 'text', 3);
        WorkContent::saveContent('project_1', 'image', 'storage/images/project-1.svg', 'image', 4);
        WorkContent::saveContent('project_1', 'link', 'https://github.com/ejemplo/proyecto-1', 'link', 5);

        // Proyecto 2
        WorkContent::saveContent('project_2', 'title', 'Aplicación Móvil de Delivery', 'text', 1);
        WorkContent::saveContent('project_2', 'description', 'App móvil para pedidos a domicilio con geolocalización, pagos en línea y seguimiento en tiempo real.', 'text', 2);
        WorkContent::saveContent('project_2', 'technologies', 'React Native, Node.js, MongoDB, Firebase', 'text', 3);
        WorkContent::saveContent('project_2', 'image', 'storage/images/project-2.svg', 'image', 4);
        WorkContent::saveContent('project_2', 'link', 'https://github.com/ejemplo/proyecto-2', 'link', 5);

        // Proyecto 3
        WorkContent::saveContent('project_3', 'title', 'E-commerce Multi-vendedor', 'text', 1);
        WorkContent::saveContent('project_3', 'description', 'Plataforma de comercio electrónico que permite a múltiples vendedores ofrecer sus productos en un solo marketplace.', 'text', 2);
        WorkContent::saveContent('project_3', 'technologies', 'Laravel, Vue.js, PostgreSQL, Redis', 'text', 3);
        WorkContent::saveContent('project_3', 'image', 'storage/images/project-3.svg', 'image', 4);
        WorkContent::saveContent('project_3', 'link', 'https://github.com/ejemplo/proyecto-3', 'link', 5);

        // Sección Servicios
        WorkContent::saveContent('services', 'title', 'Nuestros Servicios', 'text', 1);
        WorkContent::saveContent('services', 'subtitle', 'Soluciones a medida para tu empresa', 'text', 2);

        // Servicio 1
        WorkContent::saveContent('service_1', 'title', 'Desarrollo Web', 'text', 1);
        WorkContent::saveContent('service_1', 'description', 'Creamos sitios web modernos, responsivos y optimizados para SEO que convierten visitantes en clientes.', 'text', 2);
        WorkContent::saveContent('service_1', 'icon', 'storage/images/service-web.svg', 'image', 3);

        // Servicio 2
        WorkContent::saveContent('service_2', 'title', 'Aplicaciones Móviles', 'text', 1);
        WorkContent::saveContent('service_2', 'description', 'Desarrollamos apps nativas e híbridas para iOS y Android que conectan con tu audiencia móvil.', 'text', 2);
        WorkContent::saveContent('service_2', 'icon', 'storage/images/service-mobile.svg', 'image', 3);

        // Servicio 3
        WorkContent::saveContent('service_3', 'title', 'Consultoría IT', 'text', 1);
        WorkContent::saveContent('service_3', 'description', 'Asesoramos en la transformación digital de tu empresa con estrategias tecnológicas efectivas.', 'text', 2);
        WorkContent::saveContent('service_3', 'icon', 'storage/images/service-consulting.svg', 'image', 3);

        // Sección About
        WorkContent::saveContent('about', 'title', 'Sobre Nosotros', 'text', 1);
        WorkContent::saveContent('about', 'subtitle', 'Innovación y excelencia en cada proyecto', 'text', 2);
        WorkContent::saveContent('about', 'description', 'Somos un equipo apasionado por la tecnología, comprometido con entregar soluciones de alta calidad que impulsen el éxito de nuestros clientes.', 'text', 3);
        WorkContent::saveContent('about', 'image', 'storage/images/about-team.svg', 'image', 4);

        // Sección Contact
        WorkContent::saveContent('contact', 'title', 'Contáctanos', 'text', 1);
        WorkContent::saveContent('contact', 'subtitle', 'Estamos aquí para ayudarte', 'text', 2);
        WorkContent::saveContent('contact', 'email', 'info@empresa.com', 'text', 3);
        WorkContent::saveContent('contact', 'phone', '+1 (555) 123-4567', 'text', 4);
        WorkContent::saveContent('contact', 'address', 'Calle Principal 123, Ciudad, País', 'text', 5);

        // Crear registros en la tabla media
        $this->createMediaRecords();

        // Datos específicos para Work - Proyectos
        // Proyecto 1
        WorkContent::saveContent('project_1', 'title', 'CAMPAIGN AGAINST FAKE FIBRE', 'text', 1);
        WorkContent::saveContent('project_1', 'link_text', 'SWISH FIBRE', 'text', 2);
        WorkContent::saveContent('project_1', 'link', 'https://www.swishfibre.com/', 'link', 3);
        WorkContent::saveContent('project_1', 'description_1', 'A disruptive wide-scale public interest campaign to alert consumers to the major performance differences between speed-sapping copper-mix \'Fibre Broadband\' and the superior capabilities of 100% fibre-optic alternatives known as Full Fibre.', 'text', 4);
        WorkContent::saveContent('project_1', 'description_2', 'Comprising several sets of \'yin and yang\' adverts, each playfully taps into a consumer pain-point such as online gaming, hybrid working and long-winded download and upload waiting times.', 'text', 5);
        WorkContent::saveContent('project_1', 'description_3', 'The campaign has subsequently led to Ofcom commissioning proposals to improve broadband information for consumers.', 'text', 6);

        // Proyecto 2
        WorkContent::saveContent('project_2', 'title', 'STANDING ON THE SHOULDERS OF GIANTS', 'text', 1);
        WorkContent::saveContent('project_2', 'link_text', 'ACORA + GOOGLE CLOUD', 'text', 2);
        WorkContent::saveContent('project_2', 'link', 'https://www.swishfibre.com/', 'link', 3);
        WorkContent::saveContent('project_2', 'description_1', 'Acora (formerly Secrutiny) and Google were looking for an integrated campaign to help their products, services and vision to stand out within the crowded cyber security space.', 'text', 4);
        WorkContent::saveContent('project_2', 'description_2', 'We developed We have got your back and the two friendly giants at the heart of the campaign to literally stand up and above the noise. Every element of the campaign was designed to communicate the key benefits of their offering in a way that was playful, inventive and memeorable.', 'text', 5);

        // Proyecto 3
        WorkContent::saveContent('project_3', 'title', 'OPENING NEW LINES OF COMMUNICATION', 'text', 1);
        WorkContent::saveContent('project_3', 'link_text', 'NOMINET + SAMARITANS', 'text', 2);
        WorkContent::saveContent('project_3', 'link', 'https://www.swishfibre.com/', 'link', 3);
        WorkContent::saveContent('project_3', 'description_1', 'A powerful co-designed multimedia advertising campaign underwritten by Nominet, the initiative raised £150,216 for Samaritans, more than 5% over the forecast, with reach of over 12 million over a six week period.', 'text', 4);
        WorkContent::saveContent('project_3', 'description_2', 'By Experience arrived at the carefully crafted solution via a rigorous and iterative process, developing a design system and messaging framework to consider the demographics that would typically benefit from this innovative new online chat service.', 'text', 5);

        // Proyecto 4
        WorkContent::saveContent('project_4', 'title', 'CREATING A BRAND THAT GOES BEYOND BROADBAND', 'text', 1);
        WorkContent::saveContent('project_4', 'link_text', 'SWISH FIBRE - BRANDING', 'text', 2);
        WorkContent::saveContent('project_4', 'link', 'https://www.swishfibre.com/', 'link', 3);
        WorkContent::saveContent('project_4', 'description_1', 'Have you ever worked with a client that was simply an idea and didn\'t technically exist as a business in the truest sense?', 'text', 4);
        WorkContent::saveContent('project_4', 'description_2', 'The Swish founding team approached us in 2018 to help build a brand, marketing plans and compelling story to support their pending investment.', 'text', 5);
        WorkContent::saveContent('project_4', 'description_3', 'They needed a brand that was distinctive and fresh to achieve start-up status, while possessing the hallmarks of a more established to support subsequent scaling up.', 'text', 6);
        WorkContent::saveContent('project_4', 'description_4', 'Today, Swish is part of the Octopus Group and has unlocked in excess of £250m investment to establish a growing Full Fibre broadband network across South East England.', 'text', 7);
        WorkContent::saveContent('project_4', 'description_5', 'Following an initial 18-month period where we provided full operational marketing support, we have continued to work with Swish on a diverse range of strategic projects.', 'text', 8);

        // Proyecto 5
        WorkContent::saveContent('project_5', 'title', 'A BRAND THAT FINDS YOUR HAPPY PLACE', 'text', 1);
        WorkContent::saveContent('project_5', 'link_text', 'EVRY 360', 'text', 2);
        WorkContent::saveContent('project_5', 'link', 'https://www.swishfibre.com/', 'link', 3);
        WorkContent::saveContent('project_5', 'description_1', 'A disruptive wide-scale public interest campaign to alert consumers to the major performance differences between speed-sapping copper-mix Fibre Broadband and the superior capabilities of 100% fibre-optic alternatives known as Full Fibre.EVRY360 came to By Experience to develop a strong, unique brand to help establish itself as the platform leader for enabling a superior home selling and buying experience for agents and their customers alike.', 'text', 4);
        WorkContent::saveContent('project_5', 'description_2', 'Like all great brand-marks, the EVRY360 identity is iconic and unmistakably it\'s own. It was tested and chosen for it\'s stand-out appeal and avoidance of typical VR tropes.', 'text', 5);
        WorkContent::saveContent('project_5', 'description_3', 'The EVERY360 visual identity has gone on to help build a brand that is becoming synonymous with the right way to buy and sell property online.', 'text', 6);

        // Proyecto 6
        WorkContent::saveContent('project_6', 'title', 'A BRAND TO SHARE AND DO MORE', 'text', 1);
        WorkContent::saveContent('project_6', 'link_text', 'SHAREDOWN', 'text', 2);
        WorkContent::saveContent('project_6', 'link', 'https://www.swishfibre.com/', 'link', 3);
        WorkContent::saveContent('project_6', 'description_1', 'Sharedo is a legal case management platform that enables lawyers to achieve superhuman results. It creates more time by making light work of countless daily tasks, leaving you laser-focused on delivering the best outcomes for your clients.', 'text', 4);
        WorkContent::saveContent('project_6', 'description_2', 'In addition to creating this new way of talking about their exciting legal technology platform that you\'ve just read, we support Sharedo\'s ongoing brand and marketing needs. Since late 2021, we have undertaken a complete overall of their brand, positioning, online experience, social media and ongoing channel management.', 'text', 5);
        WorkContent::saveContent('project_6', 'description_3', 'Following their biggest year of growth to date in 2022, we continue to work closely with the team as they scale-up and gain market share in the UK and internationally.', 'text', 6);

        // Proyecto 7
        WorkContent::saveContent('project_7', 'title', 'A BRAND TO BUILD A COMMUNITY AND HELP PEOPLE LIVE WELL', 'text', 1);
        WorkContent::saveContent('project_7', 'link_text', 'WMUK', 'text', 2);
        WorkContent::saveContent('project_7', 'link', 'https://www.swishfibre.com/', 'link', 3);
        WorkContent::saveContent('project_7', 'description_1', 'WMUK is a very special charity and community of people that are living well with a rare blood cancer that directly affects around 4,000 in the UK today.', 'text', 4);
        WorkContent::saveContent('project_7', 'description_2', 'We\'ve been working closely with the team to refresh their brand strategy, story, look, feel and online experience so that it better reflects its values and trusted voice of WM in the UK.', 'text', 5);
        WorkContent::saveContent('project_7', 'description_3', 'Reconstructing the brand from the ground up - from the logo and distinctive yellow scenarios through to communications - the online experience supports the WM community wherever they are on their journey.', 'text', 6);

        // Proyecto 8
        WorkContent::saveContent('project_8', 'title', 'A BRAND THAT IS ALWAYS LEARNING', 'text', 1);
        WorkContent::saveContent('project_8', 'link_text', 'SPARX LEARNING', 'text', 2);
        WorkContent::saveContent('project_8', 'link', 'https://www.swishfibre.com/', 'link', 3);
        WorkContent::saveContent('project_8', 'description_1', 'Sparx Learning is on a mission to improve the life opportunities, of five million learners worldwide by 2030.', 'text', 4);
        WorkContent::saveContent('project_8', 'description_2', 'We\'ve been on that journey with them since 2018, during which time we\'ve worked closely with the team to position, launch and promote an ever-growing portfolio of learning products and services.', 'text', 5);
        WorkContent::saveContent('project_8', 'description_3', 'Most recently, we undertook a major brand review of its architecture and brand systems to better reflect and organise its portfolio, while ensuring they can continue to grow within this new strategic framework.', 'text', 6);

        // Proyecto 9
        WorkContent::saveContent('project_9', 'title', 'ADVERTISING WITH ADDED SWAGGER', 'text', 1);
        WorkContent::saveContent('project_9', 'link_text', 'NOMINET CYBER', 'text', 2);
        WorkContent::saveContent('project_9', 'link', 'https://www.swishfibre.com/', 'link', 3);
        WorkContent::saveContent('project_9', 'description_1', 'We were approached by the Nominet team to develop a diverse range of advertising concepts to help their services stand out and disrupt the sea of homogeneous marketing occurring in the industry at the time.', 'text', 4);
        WorkContent::saveContent('project_9', 'description_2', 'A set of 25 concepts were chosen to be fully realised and extensively tested, with many going on to be rolled out across social media, ABM initiatives and international events.', 'text', 5);
    }

    private function createMediaRecords()
    {
        $mediaData = [
            // Imágenes del Hero
            ['section' => 'hero', 'type' => 'image', 'name' => 'background', 'path' => 'storage/images/hero-bg.svg', 'description' => 'Imagen de fondo para la sección hero', 'order' => 1],
            
            
            // Iconos de Servicios
            ['section' => 'services', 'type' => 'image', 'name' => 'web_icon', 'path' => 'storage/images/service-web.svg', 'description' => 'Icono para desarrollo web', 'order' => 1],
            ['section' => 'services', 'type' => 'image', 'name' => 'mobile_icon', 'path' => 'storage/images/service-mobile.svg', 'description' => 'Icono para aplicaciones móviles', 'order' => 2],
            ['section' => 'services', 'type' => 'image', 'name' => 'consulting_icon', 'path' => 'storage/images/service-consulting.svg', 'description' => 'Icono para consultoría IT', 'order' => 3],
            
            // Imagen About
            ['section' => 'about', 'type' => 'image', 'name' => 'team', 'path' => 'storage/images/about-team.svg', 'description' => 'Imagen del equipo de trabajo', 'order' => 1],
            
            // Logo
            ['section' => 'logo', 'type' => 'image', 'name' => 'logo', 'path' => 'storage/images/logo.svg', 'description' => 'Logo principal de la empresa', 'order' => 1],
            ['section' => 'general', 'type' => 'image', 'name' => 'favicon', 'path' => 'storage/images/favicon.svg', 'description' => 'Favicon del sitio web', 'order' => 2],
        ];

        foreach ($mediaData as $data) {
            Media::create($data);
        }
    }
}
