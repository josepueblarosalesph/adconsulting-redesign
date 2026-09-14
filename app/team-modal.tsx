'use client';

import {useEffect, useState} from 'react';
import {X} from 'lucide-react';

export type TeamMember = {name:string; role:string; image:string; bio:string; specialties:string; linkedin?:string};

export function TeamGrid({members}:{members:TeamMember[]}){
  const [selected,setSelected] = useState<TeamMember|null>(null);
  useEffect(()=>{document.body.style.overflow=selected?'hidden':''; return ()=>{document.body.style.overflow=''}},[selected]);
  return <>
    <div className="team-grid">{members.map(member=><button type="button" className="person reveal" key={member.name} onClick={()=>setSelected(member)} aria-label={`Ver perfil de ${member.name}`}>
      <div className="person-image"><img src={member.image} alt={member.name} loading="lazy"/></div><h3>{member.name}</h3><p>{member.role}</p>
    </button>)}</div>
    {selected&&<div className="team-modal-backdrop" role="presentation" onMouseDown={e=>{if(e.target===e.currentTarget)setSelected(null)}}>
      <div className="team-modal" role="dialog" aria-modal="true" aria-labelledby="team-modal-name">
        <button type="button" className="team-modal-close" onClick={()=>setSelected(null)} aria-label="Cerrar perfil"><X size={28}/></button>
        <div className="team-modal-image"><img src={selected.image} alt={selected.name}/></div>
        <div className="team-modal-copy"><div className="team-modal-heading"><div><h2 id="team-modal-name">{selected.name}</h2><h3>{selected.role}</h3></div>{selected.linkedin&&<a href={selected.linkedin} target="_blank" rel="noreferrer" aria-label={`LinkedIn de ${selected.name}`} className="linkedin-badge">in</a>}</div><p className="team-modal-bio">{selected.bio}</p><p className="team-modal-specialties">{selected.specialties}</p></div>
      </div>
    </div>}
  </>;
}
