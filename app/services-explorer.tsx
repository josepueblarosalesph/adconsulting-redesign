'use client';

import {useState} from 'react';
import {ArrowUpRight, Plus} from 'lucide-react';
import type {CSSProperties} from 'react';

export type ServiceExplorerItem = {
  title: string;
  summary: string;
  paragraphs: string[];
  image: string;
  imageAlt: string;
  logo?: {file: string; alt: string};
  video?: string;
};

export function ServiceExplorer({services}:{services:ServiceExplorerItem[]}) {
  const [active, setActive] = useState(0);
  const service = services[active];

  return <section className="services-explorer" id="contenido" style={{'--service-image':`url("${service.image}")`} as CSSProperties}>
    <div className="services-explorer-list" role="tablist" aria-label="Servicios disponibles">
      {services.map((item, index) => <button
        key={item.title}
        id={`servicio-${index + 1}`}
        type="button"
        role="tab"
        aria-selected={active === index}
        className={active === index ? 'active' : ''}
        onClick={() => setActive(index)}
      >
        <span className="services-explorer-number">0{index + 1}</span>
        <span className="services-explorer-name">{item.title}</span>
        <Plus aria-hidden="true" size={22}/>
      </button>)}
    </div>

    <article className="services-explorer-detail" role="tabpanel" aria-labelledby={`servicio-${active + 1}`}>
      <div className="services-explorer-copy">
        <p className="eyebrow">SERVICIOS</p>
        <h2>{service.title}</h2>
        <p className="services-explorer-summary">{service.summary}</p>
        {service.paragraphs.map((paragraph, index) => <p key={index}>{paragraph}</p>)}
        {service.logo && <div className="service-partner"><img className="service-partner-logo" src={`/images/${service.logo.file}`} alt={service.logo.alt}/></div>}
        {service.video && <a href={service.video} target="_blank" rel="noreferrer" className="text-link">Si quieres saber más, ve este video <ArrowUpRight size={20}/></a>}
      </div>
      <div className="services-explorer-image" aria-hidden="true"><img src={service.image} alt=""/></div>
    </article>
  </section>;
}
