import {NextResponse} from 'next/server';
import {adminCookie,createSession,validPassword} from '@/app/lib/admin-auth';

export async function POST(request:Request){
  const body=await request.json().catch(()=>null) as {password?:unknown}|null;
  if(typeof body?.password!=='string' || !validPassword(body.password)){
    return NextResponse.json({error:'La contraseña no es válida.'},{status:401});
  }
  const session=createSession();
  const response=NextResponse.json({ok:true});
  response.cookies.set(adminCookie.name,session.value,{...adminCookie.options,maxAge:session.maxAge});
  return response;
}
