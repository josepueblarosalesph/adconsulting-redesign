import {AdminClient} from './admin-client';
import {databaseConfigured,getAllExperiences} from '@/app/lib/experiences';
import {isAdminSession} from '@/app/lib/admin-auth';

export const dynamic='force-dynamic';
export const metadata={title:'Administración de Experiencias | AD Consulting',robots:{index:false,follow:false}};

export default async function AdminPage(){
  const authenticated=await isAdminSession();
  const configured=databaseConfigured();
  const experiences=authenticated && configured ? await getAllExperiences().catch(()=>[]) : [];
  return <AdminClient authenticated={authenticated} configured={configured} initialExperiences={experiences}/>;
}
