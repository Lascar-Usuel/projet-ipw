<?php
/**
 * This file defines the controller to manage the statistics
 * @package Unsapa\IPWBundle\Controller
 */

namespace Unsapa\IPWBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Unsapa\IPWBundle\Entity\Record;
use Unsapa\IPWBundle\Entity\Promo;
use Unsapa\IPWBundle\Entity\Exam;


/**
 * Define actions of the statistics
 */
class StatsController extends Controller
{    
	/**
     * Get the averages of all the Promos
     * Route : /stats
     */
    public function averagesAction()
    {
    	$promos = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Promo")->findAll();
    	$exams = $this->getDoctrine()->getRepository("UnsapaIPWBundle:Exam")->findAll();
    	$exams_ended = array();
    	$now = new \DateTime('now');
    	
    	foreach($exams as $exam)
        {
          if($exam->getExamDate() < $now)
            array_push($exams_ended, $exam);
        }
        
        foreach($exams_ended as $exam)
        {
        	$records = $exam->getRecords();
        	$nb_records =  $records->count();
        }
    	
    	return $this->render('UnsapaIPWBundle:Stats:stats.html.twig',
    			array('promos'=>$promos, 'exams_ended'=>$exams_ended, 'nb_records'=>$nb_records));
    }
}