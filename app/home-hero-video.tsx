'use client';

import {useEffect, useRef, useState} from 'react';
import {Volume2, VolumeX} from 'lucide-react';

export function HomeHeroVideo({src}:{src:string}){
  const videoRef=useRef<HTMLVideoElement>(null);
  const [muted,setMuted]=useState(false);

  useEffect(()=>{
    const video=videoRef.current;
    if(!video)return;
    video.muted=false;
    video.volume=1;
    video.play().catch(()=>{
      video.muted=true;
      setMuted(true);
      void video.play();
    });
    const hideTimer=window.setTimeout(()=>{
      video.closest('.home-hero')?.classList.add('hero-copy-hidden');
    },7000);
    return ()=>window.clearTimeout(hideTimer);
  },[]);

  const toggleSound=()=>{
    const video=videoRef.current;
    if(!video)return;
    video.muted=!video.muted;
    setMuted(video.muted);
    void video.play();
  };

  return <>
    <video ref={videoRef} className="hero-video" autoPlay loop playsInline preload="auto">
      <source src={src} type="video/mp4"/>
    </video>
    <button type="button" className="hero-sound-toggle" onClick={toggleSound} aria-label={muted?'Activar sonido':'Silenciar video'}>
      {muted?<VolumeX size={21}/>:<Volume2 size={21}/>}<span>{muted?'Activar sonido':'Silenciar'}</span>
    </button>
  </>;
}
