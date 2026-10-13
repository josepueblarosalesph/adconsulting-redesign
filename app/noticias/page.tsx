import {NewsPage} from '../site';
import {getPublishedExperiences} from '../lib/experiences';

export const metadata = {title:'Experiencias | AD Consulting'};
export const dynamic='force-dynamic';

export default async function Page(){return <NewsPage articles={await getPublishedExperiences()}/>;}
