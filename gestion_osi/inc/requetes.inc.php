<?php

//oracle
$req['tout'] = <<<TOUT
SELECT DISTINCT app.id as app_id, inc.id as id_incident, app.enseigne as enseigne,
        TO_CHAR(imp.datestart,'YYYY-MM-DD HH24:MI:SS') as date_start,
        TO_CHAR(imp.dateend,'YYYY-MM-DD HH24:MI:SS') as date_end,
        inc.incident,
        inc.description as description_inc,
        inc.cause,
	stat.typecause,
        stat.refchangement,
		app.sigle_me as maitrise_oeuvre,
        app.libelle as lblapp,
        imp.description as description_imp,
        imp.dureepubliee,
	    inc.serviceacteur,
        stat.typoligygts,
        stat.kindimpact,
        stat.fournisseurresponsible,
		stat.legacy,
		stat.zonegeographique,
		stat.datepubpm,
        inc.responsabilite,
        imp.severite,
        inc.probleme,
        inc.datepublication,
        inc.creci,
        inc.commentaire,
        0 as powerprod,
	0 as businessimpact,
	imp.jourhomme,
        stat.responsibleteam,
		stat.*
FROM STROSI.incident inc
LEFT JOIN STROSI.chronogramme c ON c.incident_id = inc.id
LEFT JOIN STROSI.impact imp ON (imp.incident_id = inc.id OR inc.incimpact_id = imp.id)
LEFT JOIN STROSI.application app ON app.id = imp.application_id
LEFT JOIN STROSI.statistique stat ON stat.id = inc.statistique_id
TOUT;

//oracle
$req['creci'] = <<<CRECI
        SELECT DISTINCT
        TO_CHAR(imp.datestart,'YYYY-MM-DD HH24:MI:SS') as date_start,
    TO_CHAR(imp.dateend,'YYYY-MM-DD HH24:MI:SS') as date_end,
        app.id as app_id,
        imp.description as description_imp, inc.description as description_inc,
        app.libelle as app_name, inc.statut as statut_inc,
        inc.priorite as inc_priorite, app.enseigne as app_enseigne,
        inc.cause, inc.retablissement,
        inc.incident, imp.dureepubliee, stat.refchangement,
        inc.probleme, inc.responsabilite, inc.serviceacteur
        FROM STROSI.incident inc
        LEFT JOIN STROSI.statistique stat ON inc.statistique_id = stat.id
        LEFT JOIN STROSI.impact imp ON inc.incimpact_id = imp.id OR imp.incident_id = inc.id
        LEFT JOIN STROSI.application app ON imp.application_id = app.id
CRECI;

//oracle
$req['disp_applis'] = <<<DISP_APP
	SELECT calendrier.application_id as application_id,
	TO_CHAR(calendrier.lundiouverture, 'HH24:MI:SS') as lundiouverture,
	TO_CHAR(calendrier.lundifermeture, 'HH24:MI:SS') as lundifermeture,
	TO_CHAR(calendrier.mardiouverture, 'HH24:MI:SS') as mardiouverture,
	TO_CHAR(calendrier.mardifermeture, 'HH24:MI:SS') as mardifermeture,
	TO_CHAR(calendrier.mercrediouverture, 'HH24:MI:SS') as mercrediouverture,
	TO_CHAR(calendrier.mercredifermeture, 'HH24:MI:SS') as mercredifermeture,
	TO_CHAR(calendrier.jeudiouverture, 'HH24:MI:SS') as jeudiouverture,
	TO_CHAR(calendrier.jeudifermeture, 'HH24:MI:SS') as jeudifermeture,
	TO_CHAR(calendrier.vendrediouverture, 'HH24:MI:SS') as vendrediouverture,
	TO_CHAR(calendrier.vendredifermeture, 'HH24:MI:SS') as vendredifermeture,
	TO_CHAR(calendrier.samediouverture, 'HH24:MI:SS') as samediouverture,
	TO_CHAR(calendrier.samedifermeture, 'HH24:MI:SS') as samedifermeture,
	TO_CHAR(calendrier.dimancheouverture, 'HH24:MI:SS') as dimancheouverture,
	TO_CHAR(calendrier.dimanchefermeture, 'HH24:MI:SS') as dimanchefermeture,
	TO_CHAR(calendrier.feriesouverture, 'HH24:MI:SS') as feriesouverture,
	TO_CHAR(calendrier.feriesfermeture, 'HH24:MI:SS') as feriesfermeture
	FROM strosi.calendrier
DISP_APP;

?>
