'use client';

import {FormEvent,useState} from 'react';
import type {Experience} from '@/app/lib/experiences';

type ApiError={error?:string};
type UploadResponse={url:string};

type FormState={title:string;source:string;summary:string;url:string;date:string;imageUrl:string;published:boolean};
const today=()=>new Date().toISOString().slice(0,10);
const emptyForm=():FormState=>({title:'',source:'AD Consulting',summary:'',url:'',date:today(),imageUrl:'',published:true});
const ordered=(items:Experience[])=>[...items].sort((a,b)=>b.date.localeCompare(a.date));
const displayDate=(date:string)=>date.split('-').reverse().join('-');

export function AdminClient({authenticated,configured,initialExperiences}:{authenticated:boolean;configured:boolean;initialExperiences:Experience[]}){
  const [loggedIn,setLoggedIn]=useState(authenticated);
  const [experiences,setExperiences]=useState(ordered(initialExperiences));
  const [form,setForm]=useState<FormState>(emptyForm);
  const [editingId,setEditingId]=useState<string|null>(null);
  const [password,setPassword]=useState('');
  const [message,setMessage]=useState('');
  const [busy,setBusy]=useState(false);

  const login=async(event:FormEvent)=>{
    event.preventDefault(); setBusy(true); setMessage('');
    const response=await fetch('/api/admin/login',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({password})});
    if(response.ok){setLoggedIn(true); window.location.reload(); return;}
    const data=await response.json().catch(()=>({})) as ApiError; setMessage(data.error??'No fue posible iniciar sesión.'); setBusy(false);
  };
  const logout=async()=>{await fetch('/api/admin/logout',{method:'POST'}); window.location.reload();};
  const update=(key:keyof FormState,value:string|boolean)=>setForm(current=>({...current,[key]:value}));
  const save=async(event:FormEvent)=>{
    event.preventDefault(); if(!configured){setMessage('Primero configura Neon en Vercel.');return;}
    setBusy(true); setMessage('');
    const response=await fetch(editingId?`/api/admin/experiences/${editingId}`:'/api/admin/experiences',{method:editingId?'PATCH':'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({...form,imageUrl:form.imageUrl||null})});
    const data=await response.json().catch(()=>({})) as Experience|ApiError;
    if(!response.ok){setMessage((data as ApiError).error??'No fue posible guardar.');setBusy(false);return;}
    setExperiences(current=>ordered(editingId?current.map(item=>item.id===editingId?data as Experience:item):[data as Experience,...current]));
    setForm(emptyForm());setEditingId(null);setMessage(editingId?'Experiencia actualizada.':'Experiencia creada.');setBusy(false);
  };
  const edit=(item:Experience)=>{setEditingId(item.id);setForm({title:item.title,source:item.source,summary:item.summary,url:item.url,date:item.date,imageUrl:item.imageUrl??'',published:item.published});setMessage('Editando experiencia.');window.scrollTo({top:0,behavior:'smooth'});};
  const remove=async(item:Experience)=>{
    if(!window.confirm(`¿Eliminar “${item.title}”?`))return;
    const response=await fetch(`/api/admin/experiences/${item.id}`,{method:'DELETE'});
    if(!response.ok){const data=await response.json().catch(()=>({})) as ApiError;setMessage((data as ApiError).error??'No fue posible eliminar.');return;}
    setExperiences(current=>current.filter(entry=>entry.id!==item.id));setMessage('Experiencia eliminada.');
  };
  const upload=async(file:File|undefined)=>{
    if(!file)return;setBusy(true);setMessage('Subiendo imagen…');
    const data=new FormData();data.append('image',file);
    const response=await fetch('/api/admin/upload',{method:'POST',body:data});const result=await response.json().catch(()=>({})) as UploadResponse|ApiError;
    if(response.ok){update('imageUrl',(result as UploadResponse).url);setMessage('Imagen cargada.');}else setMessage((result as ApiError).error??'No fue posible subir la imagen.');
    setBusy(false);
  };

  if(!loggedIn)return <main className="admin-page"><section className="admin-login"><p className="eyebrow">AD CONSULTING</p><h1>Administración de Experiencias</h1><p>Ingresa con la contraseña configurada para publicar, editar o eliminar contenido.</p><form onSubmit={login}><label>Contraseña<input type="password" value={password} onChange={event=>setPassword(event.target.value)} autoComplete="current-password" required/></label><button className="admin-primary" disabled={busy}>{busy?'Ingresando…':'Ingresar'}</button></form>{message&&<p className="admin-message">{message}</p>}</section></main>;

  return <main className="admin-page"><div className="admin-shell"><header className="admin-header"><div><p className="eyebrow">AD CONSULTING</p><h1>Experiencias</h1></div><button className="admin-secondary" onClick={logout}>Cerrar sesión</button></header>{!configured&&<div className="admin-alert"><strong>Falta conectar Neon.</strong><br/>Configura <code>DATABASE_URL</code> en Vercel para activar la administración y conservar los cambios.</div>}<section className="admin-editor"><div><p className="eyebrow">{editingId?'EDITAR EXPERIENCIA':'NUEVA EXPERIENCIA'}</p><h2>{editingId?'Actualiza el contenido':'Publica una experiencia'}</h2></div><form onSubmit={save} className="admin-form"><label>Título<input value={form.title} onChange={event=>update('title',event.target.value)} required/></label><label>Fuente o categoría<input value={form.source} onChange={event=>update('source',event.target.value)} required/></label><label className="admin-full">Resumen<textarea value={form.summary} onChange={event=>update('summary',event.target.value)} required rows={4}/></label><label>Enlace de destino<input type="url" value={form.url} onChange={event=>update('url',event.target.value)} required placeholder="https://"/></label><label>Fecha<input type="date" value={form.date} onChange={event=>update('date',event.target.value)} required/></label><label className="admin-full">Imagen opcional<input type="file" accept="image/*" onChange={event=>upload(event.target.files?.[0])}/>{form.imageUrl&&<small>Imagen cargada: <a href={form.imageUrl} target="_blank" rel="noreferrer">ver imagen</a></small>}</label><label className="admin-check"><input type="checkbox" checked={form.published} onChange={event=>update('published',event.target.checked)}/> Publicar de inmediato</label><div className="admin-actions"><button className="admin-primary" disabled={busy||!configured}>{busy?'Guardando…':editingId?'Guardar cambios':'Crear experiencia'}</button>{editingId&&<button type="button" className="admin-secondary" onClick={()=>{setEditingId(null);setForm(emptyForm());setMessage('');}}>Cancelar</button>}</div></form>{message&&<p className="admin-message">{message}</p>}</section><section className="admin-list"><div><p className="eyebrow">CONTENIDO ACTUAL</p><h2>{experiences.length} experiencias</h2></div><div className="admin-rows">{experiences.map(item=><article className="admin-row" key={item.id}><div><time>{displayDate(item.date)}</time><h3>{item.title}</h3><p>{item.source} · {item.published?'Publicado':'Borrador'}</p></div><div className="admin-row-actions"><button className="admin-secondary" onClick={()=>edit(item)}>Editar</button><button className="admin-delete" onClick={()=>remove(item)}>Eliminar</button></div></article>)}{!experiences.length&&<p>Aún no hay experiencias creadas en la base de datos.</p>}</div></section></div></main>;
}
