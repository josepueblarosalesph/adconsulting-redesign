<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

/**
 * Contenido estático del sitio: textos importados en resources/content/source.json
 * y los datos editoriales (fotos, equipo, servicios, etc.).
 */
class SiteContent
{
    private static ?array $source = null;

    public const NAV_LINKS = [
        ['Inicio', '/'],
        ['Nosotros', '/nosotros'],
        ['Servicios', '/servicios'],
        ['Experiencias', '/noticias'],
        ['AD+50', '/ad50'],
        ['AD Black', '/black'],
    ];

    public const JOBS_URL = 'https://adconsulting.trabajando.cl/';

    public const PHOTOS = [
        ['file' => 'adconsulting-web11.jpeg', 'alt' => 'Conversación de asesoría profesional en una oficina', 'focus' => '50% 45%', 'mobile' => '35% 45%'],
        ['file' => 'adconsulting-web7.jpeg', 'alt' => 'Equipo participando en una sesión de trabajo colaborativo', 'focus' => '50% 40%', 'mobile' => '63% 40%'],
        ['file' => 'home-services.webp', 'alt' => 'Profesional trabajando en una oficina', 'focus' => '75% 35%', 'mobile' => '68% 35%'],
        ['file' => 'adconsulting-web8.jpeg', 'alt' => 'Profesionales conversando sobre una trayectoria laboral', 'focus' => '50% 40%', 'mobile' => '32% 40%'],
        ['file' => 'adconsulting-web9.jpeg', 'alt' => 'Profesional con una carpeta en un entorno empresarial', 'focus' => '50% 35%', 'mobile' => '50% 35%'],
        ['file' => 'adconsulting-web10.jpeg', 'alt' => 'Sesión de capacitación presencial con un grupo de profesionales', 'focus' => '58% 40%', 'mobile' => '63% 40%'],
        ['file' => 'adconsulting-web3.jpeg', 'alt' => 'Entrevista de selección con revisión de antecedentes', 'focus' => '50% 45%', 'mobile' => '64% 45%'],
        ['file' => 'coaching.webp', 'alt' => 'Sesión de coaching ejecutivo', 'focus' => '50% 48%', 'mobile' => '50% 42%'],
        ['file' => 'adconsulting-web5.jpeg', 'alt' => 'Sesión de orientación y acompañamiento profesional', 'focus' => '48% 45%', 'mobile' => '35% 45%'],
        ['file' => 'adconsulting-web12.jpeg', 'alt' => 'Profesional participando en una sesión de formación a distancia', 'focus' => '52% 45%', 'mobile' => '40% 45%'],
        ['file' => 'adconsulting-web14.jpeg', 'alt' => 'Mesa preparada para una reunión de asesoría', 'focus' => '60% 55%', 'mobile' => '70% 55%'],
        ['file' => 'home-team.webp', 'alt' => 'Equipo AD Consulting', 'focus' => '50% 75%', 'mobile' => '50% 75%'],
        ['file' => 'ad50-feature.webp', 'alt' => 'Equipo intergeneracional trabajando junto a un computador', 'focus' => '50% 50%', 'mobile' => '50% 50%'],
        ['file' => 'home-services.webp', 'alt' => 'Profesional trabajando en una oficina', 'focus' => '58% 35%', 'mobile' => '58% 35%'],
        ['file' => 'capacitaciones-equipo.jpeg', 'alt' => 'Equipo participante de una capacitación', 'focus' => '50% 50%', 'mobile' => '50% 50%'],
        ['file' => 'nosotros-hero-equipo.png', 'alt' => 'Equipo AD Consulting reunido en su oficina', 'focus' => '50% 42%', 'mobile' => '55% 38%'],
    ];

    public const CLIENT_LOGOS = [
        'aco.9bb88454.webp', 'altos_valle.920bb7b9.webp', 'arauco.e142d465.webp', 'biodiversa.24c5745c.webp',
        'blumar.d36b0385.webp', 'clinica_andes.52b94335.webp', 'clinica_biobio.5640ab5d.webp', 'cmp.85632906.webp',
        'cpc_biobio.1e1597e3.webp', 'dpc.bcbccdf2.webp', 'ds.1ac56f73.webp', 'eo.3afe284b.webp',
        'estadio_espanol.3b05e6da.webp', 'grupo_avanza.d99b2b45.webp', 'isla_maquinarias.0d4de502.webp', 'itahue.c7ec7b65.webp',
        'leon.6fe82453.webp', 'masonite.58973ced.webp', 'mnk.8c4e1ca2.webp', 'molycop.07b592f5.webp',
        'mvc.9ce61772.webp', 'orizon.7c7badc9.webp', 'pinares.63214379.webp', 'puerto_coronel.0de52f08.webp',
        'san_vicente.e850cae0.webp', 'sanatorio_aleman.067f550c.webp', 'santa_blanca.94159c9a.webp', 'setop.adfdef7e.webp',
        'udd.b9000488.webp', 'uss.48e6c981.webp', 'ust.e50ce338.webp', 'valmar.92e8d890.webp',
        'aguas-antofagasta.jpeg', 'neumann.jpeg', 'bodega-outlet.jpeg', 'terramar.jpeg',
        'aguas-hidro-sur.jpeg', 'nutrisco.jpeg', 'enel.jpeg', 'cec.jpeg',
    ];

    /** Índices de los títulos de servicio dentro de source.servicios.text */
    public const SERVICE_INDICES = [3, 5, 7, 11, 17];

    public const SERVICE_TITLES = ['Head Hunting', 'Reclutamiento y Selección', 'Coaching y Desarrollo de Liderazgo', 'Outplacement', 'Capacitaciones'];

    public const SERVICE_SUMMARIES = [
        'Búsqueda especializada de talento para cargos directivos y ejecutivos, donde la competencia por los mejores perfiles es alta. Identificamos y atraemos a los candidatos idóneos para posiciones clave.',
        'Transformamos un proceso normalmente agotador en una experiencia ágil y sin complicaciones. Encontramos al candidato correcto de forma eficiente y libre de estrés.',
        'Ofrecemos soluciones basadas en datos para desarrollar liderazgo, mejorar la efectividad de equipos y fortalecer la confianza organizacional. Buscamos potenciar el desempeño y el crecimiento continuo.',
        'Acompañamos a profesionales en transición laboral con orientación personalizada hasta su recolocación. Un servicio para empresas y particulares comprometidos con un futuro laboral más ético.',
        'Diseñamos programas de formación e-learning, b-learning y presenciales, adaptados a cada necesidad. Somos OTEC certificado por SENCE bajo la norma NCh 2728.',
    ];

    public const LOSS_CARDS = [
        ['title' => 'La empresa', 'summary' => 'Pierde productividad, conocimiento y continuidad.', 'items' => ['Rotación silenciosa y pérdidas operacionales.', 'Vacantes que el mercado joven no cubre.', 'Tensiones intergeneracionales sin gestión efectiva.']],
        ['title' => 'El profesional +50', 'summary' => 'Pierde vigencia, ingresos y trayectoria.', 'items' => ['Sale del mercado formal hacia la informalidad y subempleo.', 'Desactualización digital e IA, nuevas habilidades de gestión y narrativa profesional vencida.', 'Ausencia de redes, invisibilidad profesional y pérdida de confianza.']],
        ['title' => 'La sociedad', 'summary' => 'Pierde competitividad y sostenibilidad económica.', 'items' => ['Pérdida de competitividad y sostenibilidad económica.', 'Presión sobre pensiones y otras prestaciones sociales.', 'Impacto sobre la salud mental y vulnerabilidad psicosocial.']],
    ];

    public const COMPARISON_CARDS = [
        ['title' => 'Lo que las Empresas suelen pensar', 'items' => ['Son caros y producen lo mismo que jóvenes talentosos más baratos.', 'Están desactualizados y son adversos a los cambios.']],
        ['title' => 'Lo que realmente está pasando', 'items' => ['Aumentos de costo por rotación, pérdidas operacionales y de continuidad.', 'Dificultades en el reclutamiento de fuera laboral joven.', 'Débil gestión de las relaciones intergeneracionales.']],
    ];

    public const TEAM = [
        ['Ariela Dymensztain', 'Directora', 'Lidera AD Consulting con una mirada estratégica y cercana, conectando las necesidades de las organizaciones con el desarrollo de sus personas.', 'Estrategia · Gestión de talento · Liderazgo'],
        ['Gian Piero Lavezzo', 'Socio Gerente', 'Acompaña a empresas y equipos en decisiones de talento, crecimiento y transformación organizacional con foco en resultados sostenibles.', 'Gestión empresarial · Consultoría · Desarrollo organizacional'],
        ['Stephany Vásquez', 'Directora Académica OTEC', 'Diseña experiencias de aprendizaje que fortalecen las capacidades de las personas y preparan a los equipos para los desafíos actuales.', 'Formación · Desarrollo de competencias · Liderazgo'],
        ['Jocelyn Bon', 'Jefa de Selección', 'Conecta a las personas con oportunidades donde puedan aportar su experiencia, motivación y talento.', 'Selección · Evaluación · Atracción de talento'],
        ['Daniela Rojas', 'Consultora Senior Bilingüe', 'Acompaña procesos de selección y desarrollo con una perspectiva internacional y una comunicación cercana.', 'Consultoría · Selección bilingüe · Desarrollo profesional'],
        ['Evelyn Jofré', 'Consultora Senior', 'En nuestro equipo, cada persona aporta lo mejor y construye un entorno que prioriza el bienestar y la salud mental.', 'Psicóloga · Igualdad y Justicia · Cercanía y Afectividad · Entusiasmo y Energía'],
        ['Danilo Vásquez', 'Consultor Senior', 'Apoya a organizaciones en la gestión de personas y en la construcción de equipos de alto desempeño.', 'Consultoría · Gestión de personas · Desarrollo de equipos'],
        ['Eugenia Gutierrez', 'Ejecutiva Comercial', 'Construye relaciones de confianza para acercar soluciones de talento a cada desafío organizacional.', 'Relación con clientes · Desarrollo comercial · Servicio'],
        ['Elena Soto', 'Consultora Senior', 'Acompaña a profesionales y organizaciones en procesos de cambio, crecimiento y nuevas oportunidades.', 'Consultoría · Outplacement · Acompañamiento'],
        ['Rocio Castillo', 'Consultora Senior y Community Manager', 'Impulsa conversaciones y vínculos que conectan el talento con nuevas posibilidades de colaboración.', 'Comunidad · Comunicación · Gestión de talento'],
        ['Darío Cerro', 'Encargado de Finanzas', 'Cuida la gestión financiera que permite que cada proyecto avance con orden y sostenibilidad.', 'Finanzas · Gestión · Planificación'],
    ];

    /** Contenido importado del sitio anterior. */
    public static function source(?string $key = null): array
    {
        self::$source ??= json_decode(File::get(resource_path('content/source.json')), true, flags: JSON_THROW_ON_ERROR);

        return $key === null ? self::$source : self::$source[$key];
    }

    public static function photo(int $index): array
    {
        return self::PHOTOS[$index];
    }

    /** Variables CSS que controlan el encuadre de una foto. */
    public static function photoStyle(int $index): string
    {
        $photo = self::PHOTOS[$index];

        return "--photo-focus:{$photo['focus']};--photo-focus-mobile:{$photo['mobile']}";
    }

    /** Enlaces del menú móvil: navegación principal + recursos. */
    public static function mobileLinks(): array
    {
        return [
            ...self::NAV_LINKS,
            ['Ofertas de Trabajo', self::JOBS_URL],
            ['Hablemos', '#contacto'],
        ];
    }

    public static function teamMembers(): array
    {
        $images = self::source('nosotros')['images'];

        return array_map(function (array $member, int $i) use ($images) {
            [$name, $role, $bio, $specialties] = $member;

            return [
                'name' => $name,
                'role' => $role,
                'bio' => $bio,
                'specialties' => $specialties,
                'image' => $images[$i]['src'],
                'linkedin' => match ($i) {
                    0 => 'https://www.linkedin.com/in/ariela-dymensztain-ad/',
                    4 => 'https://www.linkedin.com/in/danielarojagu',
                    default => 'https://www.linkedin.com/search/results/people/?keywords='.rawurlencode($name),
                },
            ];
        }, self::TEAM, array_keys(self::TEAM));
    }

    public static function services(): array
    {
        $text = self::source('servicios')['text'];
        $logos = [
            null,
            null,
            ['file' => 'logo-lcchile.d74a881e.webp', 'alt' => 'Leadership Consulting Chile'],
            ['file' => 'logo-lukkap.66d45d22.webp', 'alt' => 'Lukkap Chile'],
            ['file' => 'ad_cap.6fba57c1.webp', 'alt' => 'AD Capacitaciones'],
        ];
        $images = [0, 6, 7, 8, 14];
        $videos = [
            2 => 'https://www.youtube.com/watch?v=XOzHQBbgBEM&ab_channel=ReddeRRHH',
            3 => 'https://youtu.be/2a7JT4ILtOI',
        ];
        $positions = [2 => 'center', 4 => 'center 35%'];

        return array_map(function (int $n, int $i) use ($text, $logos, $images, $videos, $positions) {
            $paragraphs = [$text[$n + 1]];
            if ($i === 3) {
                array_push($paragraphs, $text[13], $text[14]);
            }
            if ($i === 4) {
                $paragraphs[] = $text[19];
            }

            return [
                'title' => self::SERVICE_TITLES[$i],
                'summary' => self::SERVICE_SUMMARIES[$i],
                'paragraphs' => $paragraphs,
                'image' => '/images/'.self::PHOTOS[$images[$i]]['file'],
                'imageAlt' => self::PHOTOS[$images[$i]]['alt'],
                'imagePosition' => $positions[$i] ?? 'center top',
                'logo' => $logos[$i],
                'video' => $videos[$i] ?? null,
            ];
        }, self::SERVICE_INDICES, array_keys(self::SERVICE_INDICES));
    }

    /** Experiencias incluidas en el proyecto (base inicial y respaldo si falla la base de datos). */
    public static function staticExperiences(): array
    {
        return array_map(fn (array $article, int $i) => [
            'id' => "original-{$i}",
            'title' => $article['title'],
            'source' => $article['source'],
            'summary' => $article['summary'],
            'url' => $article['url'],
            'date' => self::isoDate($article['date']),
            'image_url' => null,
            'published' => true,
        ], self::source('noticias')['articles'], array_keys(self::source('noticias')['articles']));
    }

    private static function isoDate(string $value): string
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return $value;
        }
        [$day, $month, $year] = explode('-', $value);

        return "{$year}-{$month}-{$day}";
    }
}
