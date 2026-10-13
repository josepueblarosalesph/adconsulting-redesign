import {createHmac, timingSafeEqual} from 'node:crypto';
import {cookies} from 'next/headers';

const COOKIE_NAME='ad_consulting_admin';
const MAX_AGE=60*60*24*7;

function secret(){return process.env.ADMIN_SESSION_SECRET ?? process.env.ADMIN_PASSWORD ?? '';}
function sign(expiresAt:string){return createHmac('sha256',secret()).update(expiresAt).digest('hex');}

export function validPassword(password:string){
  const expected=process.env.ADMIN_PASSWORD ?? '';
  if(!expected || password.length!==expected.length)return false;
  return timingSafeEqual(Buffer.from(password),Buffer.from(expected));
}

export function createSession(){
  const expiresAt=String(Date.now()+MAX_AGE*1000);
  return {value:`${expiresAt}.${sign(expiresAt)}`,maxAge:MAX_AGE};
}

function validSession(value?:string){
  if(!value || !secret())return false;
  const [expiresAt,signature]=value.split('.');
  if(!expiresAt || !signature || Number(expiresAt)<Date.now())return false;
  const expected=sign(expiresAt);
  return signature.length===expected.length && timingSafeEqual(Buffer.from(signature),Buffer.from(expected));
}

export async function isAdminSession(){
  const store=await cookies();
  return validSession(store.get(COOKIE_NAME)?.value);
}

export const adminCookie={name:COOKIE_NAME,options:{httpOnly:true,secure:process.env.NODE_ENV==='production',sameSite:'lax' as const,path:'/',maxAge:MAX_AGE}};
