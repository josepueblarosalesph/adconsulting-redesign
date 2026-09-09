import type { Metadata } from 'next';
import './globals.css';
export const metadata: Metadata = { icons: {icon:'/favicon.ico'}, title: 'AD Consulting | Seleccionamos y potenciamos el talento', description: 'Más de 14 años de experiencia en gestión de talento, Head Hunting, selección, capacitación y coaching ejecutivo.' };
export default function RootLayout({ children }: {children: React.ReactNode}) { return <html lang="es"><body>{children}</body></html>; }
