'use client';
import {ReactNode,useState} from 'react';

export function ServiceCarousel({children}:{children:ReactNode[]}){
 const [active,setActive]=useState(0);
 const total=children.length;
 return <div className="service-carousel"><div className="service-carousel-window"><div className="service-carousel-track" style={{transform:`translateX(-${active*100}%)`}}>{children.map((child,i)=><div className="service-carousel-slide" key={i}>{child}</div>)}</div></div><div className="service-carousel-controls"><button aria-label="Servicio anterior" onClick={()=>setActive(n=>(n+total-1)%total)}>←</button><div>{children.map((_,i)=><button key={i} className={active===i?'active':''} aria-label={`Ver servicio ${i+1}`} aria-pressed={active===i} onClick={()=>setActive(i)}/>)}</div><button aria-label="Servicio siguiente" onClick={()=>setActive(n=>(n+1)%total)}>→</button></div></div>
}
