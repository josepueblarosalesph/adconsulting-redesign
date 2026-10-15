import {randomUUID} from 'node:crypto';
import {neon} from '@neondatabase/serverless';
import source from '@/content/source.json';

export type Experience={id:string;title:string;source:string;summary:string;url:string;date:string;imageUrl:string|null;published:boolean};
export type ExperienceInput=Omit<Experience,'id'>;

const hasDatabase=()=>Boolean(process.env.DATABASE_URL);
const removedExperienceUrls=['https://lnkd.in/p/dsvHGpTU'];
const requiredStaticExperienceUrls=[
  'https://open.spotify.com/episode/7G7l54am3KJC9HLv1WM0BZ',
  'https://revistanos.cl/ad-consulting-firmo-alianzas-con-lukkap-y-leadership-consulting/',
  'https://revistanos.cl/liderazgo-y-ley-karin-los-nuevos-desafios-culturales/',
  'https://revistanos.cl/ad-consulting-crece-gian-piero-lavezzo-se-suma-como-socio-gerente-y-se-incorporan-dos-marcas-internacionales/',
  'https://revistanos.cl/equipo-ad-consulting-una-decada-generando-valor-en-la-forma-de-seleccionar-a-las-personas/',
  'https://revistanos.cl/47273-2/',
  'https://revistanos.cl/60166-2/',
  'https://revistanos.cl/aspectos-positivos-de-la-digitalizacion-en-hunting-y-seleccion-de-talentos/',
  'https://revistanos.cl/la-otec-que-transformara-la-experiencia-de-aprendizaje/',
  'https://revistanos.cl/la-equidad-de-genero-en-el-mundo-laboral-parte-desde-la-seleccion/',
  'https://revistanos.cl/la-cuarentena-requiere-contencion-y-desahogo/',
  'https://revistanos.cl/entrevistas-online-la-nueva-tendencia-en-la-seleccion-de-personas/',
  'https://revistanos.cl/trabajo-mixto-el-nuevo-escenario-laboral/',
  'https://revistanos.cl/las-oportunidades-del-coaching/',
  'https://revistanos.cl/la-pandemia-y-la-salud-de-los-trabajadores/',
  'https://revistanos.cl/ad-consulting-a-la-vanguardia-en-reclutamiento-y-seleccion-online/',
  'https://revistanos.cl/un-camino-seguro-hacia-el-empleo/'
];
const isoDate=(value:string)=>{
  if(/^\d{4}-\d{2}-\d{2}$/.test(value))return value;
  const [day,month,year]=value.split('-');
  return `${year}-${month}-${day}`;
};
const staticExperiences:Experience[]=source.noticias.articles.map((article,index)=>({
  id:`original-${index}`,
  title:article.title,
  source:article.source,
  summary:article.summary,
  url:article.url,
  date:isoDate(article.date),
  imageUrl:null,
  published:true,
}));
const formatRow=(row:Record<string,unknown>):Experience=>({
  id:String(row.id),title:String(row.title),source:String(row.source),summary:String(row.summary),url:String(row.url),
  date:String(row.published_at).slice(0,10),imageUrl:row.image_url?String(row.image_url):null,published:Boolean(row.published),
});

async function database(){
  if(!process.env.DATABASE_URL)throw new Error('DATABASE_URL no está configurada');
  const sql=neon(process.env.DATABASE_URL);
  await sql`CREATE TABLE IF NOT EXISTS experiences (
    id TEXT PRIMARY KEY,
    title TEXT NOT NULL,
    source TEXT NOT NULL,
    summary TEXT NOT NULL,
    url TEXT NOT NULL UNIQUE,
    image_url TEXT,
    published_at DATE NOT NULL,
    published BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
  )`;
  await sql`CREATE TABLE IF NOT EXISTS experience_admin_settings (
    key TEXT PRIMARY KEY,
    value TEXT NOT NULL
  )`;
  const seeded=await sql`SELECT key FROM experience_admin_settings WHERE key='initial-seed'`;
  if(!seeded[0]){
    for(const item of staticExperiences){
      await sql`INSERT INTO experiences (id,title,source,summary,url,image_url,published_at,published)
        VALUES (${item.id},${item.title},${item.source},${item.summary},${item.url},${item.imageUrl},${item.date},TRUE)
        ON CONFLICT (url) DO NOTHING`;
    }
    await sql`INSERT INTO experience_admin_settings (key,value) VALUES ('initial-seed','done') ON CONFLICT (key) DO NOTHING`;
  }
  for (const removedUrl of removedExperienceUrls) {
    await sql`DELETE FROM experiences WHERE url = ${removedUrl}`;
  }

  for (const requiredUrl of requiredStaticExperienceUrls) {
    const item=staticExperiences.find((experience)=>experience.url===requiredUrl);
    if(item) await sql`INSERT INTO experiences (id,title,source,summary,url,image_url,published_at,published)
      VALUES (${item.id},${item.title},${item.source},${item.summary},${item.url},${item.imageUrl},${item.date},TRUE)
      ON CONFLICT (url) DO NOTHING`;
  }

  return sql;
}

export function databaseConfigured(){return hasDatabase();}

export async function getPublishedExperiences():Promise<Experience[]>{
  if(!hasDatabase())return [...staticExperiences].sort((a,b)=>b.date.localeCompare(a.date));
  try{
    const sql=await database();
    const rows=await sql`SELECT id,title,source,summary,url,image_url,published_at,published FROM experiences WHERE published=TRUE ORDER BY published_at DESC, created_at DESC`;
    return rows.map(row=>formatRow(row as Record<string,unknown>));
  }catch(error){
    console.error('No fue posible cargar Experiencias desde la base de datos',error);
    return [...staticExperiences].sort((a,b)=>b.date.localeCompare(a.date));
  }
}

export async function getAllExperiences():Promise<Experience[]>{
  if(!hasDatabase())return staticExperiences;
  const sql=await database();
  const rows=await sql`SELECT id,title,source,summary,url,image_url,published_at,published FROM experiences ORDER BY published_at DESC, created_at DESC`;
  return rows.map(row=>formatRow(row as Record<string,unknown>));
}

export function cleanExperience(input:Partial<ExperienceInput>):ExperienceInput{
  const title=String(input.title??'').trim();
  const sourceName=String(input.source??'AD Consulting').trim();
  const summary=String(input.summary??'').trim();
  const url=String(input.url??'').trim();
  const date=String(input.date??'').trim();
  const imageUrl=input.imageUrl?String(input.imageUrl).trim():null;
  if(!title || !sourceName || !summary || !url || !/^\d{4}-\d{2}-\d{2}$/.test(date))throw new Error('Completa título, fuente, resumen, enlace y fecha.');
  try{new URL(url);}catch{throw new Error('Ingresa un enlace válido.');}
  return {title,source:sourceName,summary,url,date,imageUrl,published:Boolean(input.published)};
}

export async function createExperience(input:ExperienceInput){
  const sql=await database();
  const id=randomUUID();
  const rows=await sql`INSERT INTO experiences (id,title,source,summary,url,image_url,published_at,published)
    VALUES (${id},${input.title},${input.source},${input.summary},${input.url},${input.imageUrl},${input.date},${input.published})
    RETURNING id,title,source,summary,url,image_url,published_at,published`;
  return formatRow(rows[0] as Record<string,unknown>);
}

export async function updateExperience(id:string,input:ExperienceInput){
  const sql=await database();
  const rows=await sql`UPDATE experiences SET title=${input.title},source=${input.source},summary=${input.summary},url=${input.url},image_url=${input.imageUrl},published_at=${input.date},published=${input.published},updated_at=NOW()
    WHERE id=${id} RETURNING id,title,source,summary,url,image_url,published_at,published`;
  if(!rows[0])throw new Error('No se encontró la experiencia.');
  return formatRow(rows[0] as Record<string,unknown>);
}

export async function deleteExperience(id:string){
  const sql=await database();
  await sql`DELETE FROM experiences WHERE id=${id}`;
}
