import {NextResponse} from 'next/server';
import {isAdminSession} from '@/app/lib/admin-auth';
import {cleanExperience,databaseConfigured,deleteExperience,updateExperience} from '@/app/lib/experiences';

const unauthorized=()=>NextResponse.json({error:'Sesión no autorizada.'},{status:401});
const unavailable=()=>NextResponse.json({error:'Configura DATABASE_URL para administrar Experiencias.'},{status:503});

type Context={params:Promise<{id:string}>};

export async function PATCH(request:Request,{params}:Context){
  if(!await isAdminSession())return unauthorized();
  if(!databaseConfigured())return unavailable();
  try{
    const {id}=await params;
    const experience=await updateExperience(id,cleanExperience(await request.json()));
    return NextResponse.json(experience);
  }catch(error){return NextResponse.json({error:error instanceof Error?error.message:'No fue posible actualizar la experiencia.'},{status:400});}
}

export async function DELETE(_request:Request,{params}:Context){
  if(!await isAdminSession())return unauthorized();
  if(!databaseConfigured())return unavailable();
  try{
    const {id}=await params;
    await deleteExperience(id);
    return NextResponse.json({ok:true});
  }catch(error){return NextResponse.json({error:error instanceof Error?error.message:'No fue posible eliminar la experiencia.'},{status:400});}
}
