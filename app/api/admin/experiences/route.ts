import {NextResponse} from 'next/server';
import {isAdminSession} from '@/app/lib/admin-auth';
import {cleanExperience,createExperience,databaseConfigured,getAllExperiences} from '@/app/lib/experiences';

const unauthorized=()=>NextResponse.json({error:'Sesión no autorizada.'},{status:401});
const unavailable=()=>NextResponse.json({error:'Configura DATABASE_URL para administrar Experiencias.'},{status:503});

export async function GET(){
  if(!await isAdminSession())return unauthorized();
  if(!databaseConfigured())return unavailable();
  try{return NextResponse.json(await getAllExperiences());}
  catch(error){return NextResponse.json({error:error instanceof Error?error.message:'No fue posible cargar las experiencias.'},{status:500});}
}

export async function POST(request:Request){
  if(!await isAdminSession())return unauthorized();
  if(!databaseConfigured())return unavailable();
  try{
    const experience=await createExperience(cleanExperience(await request.json()));
    return NextResponse.json(experience,{status:201});
  }catch(error){return NextResponse.json({error:error instanceof Error?error.message:'No fue posible guardar la experiencia.'},{status:400});}
}
