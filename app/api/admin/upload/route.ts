import {put} from '@vercel/blob';
import {NextResponse} from 'next/server';
import {isAdminSession} from '@/app/lib/admin-auth';

export async function POST(request:Request){
  if(!await isAdminSession())return NextResponse.json({error:'Sesión no autorizada.'},{status:401});
  try{
    const form=await request.formData();
    const image=form.get('image');
    if(!(image instanceof File) || !image.type.startsWith('image/'))return NextResponse.json({error:'Selecciona una imagen válida.'},{status:400});
    if(image.size>4*1024*1024)return NextResponse.json({error:'La imagen debe pesar menos de 4 MB.'},{status:400});
    const blob=await put(`experiencias/${image.name}`,image,{access:'public',addRandomSuffix:true});
    return NextResponse.json({url:blob.url});
  }catch(error){return NextResponse.json({error:error instanceof Error?error.message:'No fue posible subir la imagen.'},{status:400});}
}
