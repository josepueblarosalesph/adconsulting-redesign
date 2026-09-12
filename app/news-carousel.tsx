'use client';
import {useEffect,useState} from 'react';
type Story={url:string;title:string;image:string};
export function NewsCarousel({stories}:{stories:Story[]}){
 const [active,setActive]=useState(0),[paused,setPaused]=useState(false);
 useEffect(()=>{if(paused||matchMedia('(prefers-reduced-motion: reduce)').matches)return;const id=setInterval(()=>setActive(n=>(n+1)%stories.length),6000);return()=>clearInterval(id)},[paused,stories.length]);
 return <div className="news-carousel" onMouseEnter={()=>setPaused(true)} onMouseLeave={()=>setPaused(false)} onFocusCapture={()=>setPaused(true)}>
 <div className="news-carousel-window"><div className="news-carousel-track" style={{transform:`translateX(-${active*100}%)`}}>{stories.map((story,i)=><article className="news-slide" key={story.url} aria-hidden={i!==active}><img src={story.image} alt="" loading="lazy"/><div><p className="eyebrow">ACTUALIDAD · 0{i+1}</p><h2>{story.title}</h2><a className="text-link" href={story.url} target="_blank" rel="noreferrer" tabIndex={i===active?0:-1}>Leer experiencia ↗</a></div></article>)}</div></div>
 <div className="news-carousel-controls"><button aria-label="Noticia anterior" onClick={()=>setActive(n=>(n+stories.length-1)%stories.length)}>←</button><div>{stories.map((s,i)=><button key={s.url} className={active===i?'active':''} aria-label={`Ver noticia ${i+1}`} aria-pressed={active===i} onClick={()=>setActive(i)}/>)}</div><button aria-label="Noticia siguiente" onClick={()=>setActive(n=>(n+1)%stories.length)}>→</button><button onClick={()=>setPaused(p=>!p)} aria-label={paused?'Reanudar carrusel':'Pausar carrusel'}>{paused?'▶':'Ⅱ'}</button></div></div>
}
