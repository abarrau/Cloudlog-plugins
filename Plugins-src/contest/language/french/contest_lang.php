<?php

defined('BASEPATH') OR exit('No direct script access allowed');


$lang['pluginsext_allow_helpertxt'] = 'Activer ce nouveau plugin';
$lang['contest_bddcoluserdef_namecontest'] = '[technique] Nom du champs pour "Contest ID"';
$lang['contest_bddcoluserdef_pts'] = '[technique] Nom du champs pour sauvegarder les "Points"';
$lang['contest_allow_screen_oncontestpage'] = 'Afficher scores (page contest)';
$lang['contest_period_not_activity_allowed'] = 'Période d\'inactivité autorisée (entre 2 QSO)';
$lang['contest_period_timeplotter'] = 'Période groupée (graph heure)';

$lang['contest_list'] = 'Liste des Concours';
$lang['contest_name'] = 'Nom du concours';
$lang['contest_name_cloudlog'] = 'Attaché au contest cloudlog';
$lang['contest_date'] = 'Période';
$lang['contest_date_start'] = 'Date/heure (début)';
$lang['contest_date_end'] = 'Date/heure (fin)';
$lang['contest_score'] = 'Résultat';
$lang['contest_add'] = 'Ajouter un concours';
$lang['contest_statistic'] = 'Statistiques';
$lang['contest_nb_qso'] = 'Nbre QSO';
$lang['contest_countdown'] = 'Décompte';
$lang['contest_bands'] = 'Bandes';
$lang['contest_include'] = 'Inclus';
$lang['contest_duration'] = 'Durée';
$lang['contest_active'] = 'Actif';
$lang['contest_inactive'] = 'Inactif';
$lang['contest_select_value'] = 'Sélectionnez les valeurs';
$lang['contest_new'] = 'Nouveau';
$lang['contest_qso_by_hour'] = 'QSO/Heure';
$lang['contest_not_result_yet'] = 'Pas de résultat disponible.';
$lang['contest_dup'] = 'Doublon';
$lang['contest_best_distance'] = 'Meilleure distance';
$lang['contest_info'] = 'Info';
$lang['contest_tooltip'] = 'Info bulle';

$lang['contest_score_tab_col'] = 'Données "en colonne"';
$lang['contest_score_tab_row'] = 'Données "en ligne"';
$lang['contest_score_synth'] = 'Score Synthèse';
$lang['contest_score_final'] = 'Score Synthèse';
$lang['contest_score_calcul_point_method'] = 'Modèle de calcul des points';

$lang['contest_statistics'] = 'Statistiques du concours';
$lang['contest_stat_global'] = 'Statistiques globales';
$lang['contest_stat_bytime'] = 'Vue par créneau horaire';
$lang['contest_stat_nb_qso_descrip'] = 'Nombre de QSO comptabilisés pour le concours, sur la totalité de la période correspondant au concours';

$lang['contest_conf'] = 'Paramètre du concours';
$lang['contest_conf_log'] = 'Paramètre des log';
$lang['contest_conf_score_tab'] = 'Paramètre du tableau des Scores';
$lang['contest_conf_offical_result'] = 'Résultat(s) officel(s)';
$lang['contest_conf_other'] = 'Autres paramètres';
$lang['contest_conf_multi'] = 'Multiplicateurs';

$lang['contest_log_select'] = 'Choisissez un format du log, pour pouvoir le paramétrer';
$lang['contest_log_type'] = 'Format du log';
$lang['contest_log_callsign'] = 'Indicatif utilisé';
$lang['contest_log_club'] = 'Nom du club';
$lang['contest_log_ops'] = 'Operateurs (si MULTI) (sépararer par des ;)';
$lang['contest_log_cat_assist'] = 'Assisté';
$lang['contest_log_cat_band'] = 'Bande';
$lang['contest_log_cat_mode'] = 'Mode';
$lang['contest_log_exch'] = 'Echange utilisé';
$lang['contest_log_Pinfos'] = 'Informations liées au lieu d\'émission';
$lang['contest_log_padr1'] = 'Adresse';
$lang['contest_log_padr2'] = 'CP Ville';
$lang['contest_log_sect'] = 'Section';
$lang['contest_log_Presp'] = 'Informations sur le responsable de la station';
$lang['contest_log_rname'] = 'Nom et prénom';
$lang['contest_log_rcallsign'] = 'Indicatif';
$lang['contest_log_radr1'] = 'Adresse';
$lang['contest_log_radr2'] = 'Adresse (suite)';
$lang['contest_log_rpostcode'] = 'CP';
$lang['contest_log_rcity'] = 'Ville';
$lang['contest_log_rcountry'] = 'Pays';
$lang['contest_log_rphone'] = 'Téléphone';
$lang['contest_log_remail'] = 'Email';
$lang['contest_log_power'] = 'Puissance';
$lang['contest_log_equip'] = 'Description équipement';
$lang['contest_log_antenna'] = 'Description antenne';
$lang['contest_log_antenna_h1'] = 'Hauteur antenne /sol';
$lang['contest_log_antenna_h2'] = 'Hauteur antenne /mer';
$lang['contest_log_remarks'] = 'Remarques sur le concours';
$lang['contest_log_export'] = 'Log à exporter';
$lang['contest_log_select_band_title'] = 'Sélectionnez une bande';
$lang['contest_log_select_band'] = 'Choisissez une bande, pour afficher le log';
$lang['contest_log_download'] = 'Télécharger';

$lang['contest_log_use_cabrillo_cloudlog'] = 'Utiliser la fonction "Export Cabrillo" de Cloudlog';
$lang['contest_log_use_cabrillo_btn'] = 'Cabrillo Export';

$lang['contest_score_url'] = 'Site/url où se trouve les résultats';
$lang['contest_score_category'] = 'Catégorie';
$lang['contest_score_position'] = 'Position';
$lang['contest_score_nbparticipant'] = 'Nombre participants';
$lang['contest_score_finalscore'] = 'Score final';
$lang['contest_score_category_add'] = 'Ajouter Catégorie';

$lang['contest_other_update_pts'] = "Calcul des points";
$lang['contest_other_update_pts_alert'] = "Confirmez-vous la mise à jour de tous les QSO ?<br>(ATTENTION: cela effacera le point déjà existants dans le champs 'user defined' de la table LOG)";
$lang['contest_other_autoupdate_now'] = "Tout mettre à jour maintenant";
$lang['contest_save_first_before_action'] = "Vous devez sauvegarder une 1ère fois, avant de faire cette action.";
$lang['contest_cancel_confirm_txt'] = 'Confirmez-vous l\'annulation de la création/modifications ?';
$lang['contest_copy_paramlog_warning'] = 'A la sélection du concours toutes les données des sections "'.$lang['contest_log_Presp'].'" et "'.$lang['contest_log_Pinfos'].'" seront automatiquement recopiées.<br/>Cette action écrasera les données existantes.';
$lang['contest_copy_paramlog'] = "Copie des paramètres de log";

