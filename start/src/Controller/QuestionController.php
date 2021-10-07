<?php

namespace App\Controller;

use App\Service\MarkdownHelper;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Sentry\State\HubInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Twig\Environment;

final class QuestionController extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var bool
     */
    private $isDebug;

    public function __construct(LoggerInterface $logger, bool $isDebug)
    {

        $this->logger  = $logger;
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(Environment $twigEnvironment): Response
    {

        /*
        // fun example of using the Twig service directly!
        $html = $twigEnvironment->render('question/homepage.html.twig');

        return new Response($html);
        */

        return $this->render('question/homepage.html.twig');
    }

    /**
     * @Route("/questions/{slug}", name="app_question_show")
     * @param                $slug
     * @param MarkdownHelper $markdownHelper
     *
     * @return Response
     */
    public function show($slug, MarkdownHelper $markdownHelper): Response
    {

        if ($this->isDebug) {
            $this->logger->info('We are a debug mode!');
        }

        throw new \Exception('Esto es un error');

        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];

        $questionText = "I've been turned into a cat, any **thoughts** on how to turn back? While I'm **adorable**, I don't really care for cat food.";

        return $this->render('question/show.html.twig', [
            'question' => ucwords(str_replace('-', ' ', $slug)),
            'questionText' => $markdownHelper->parse($questionText),
            'answers' => $answers,
        ]);
    }

}
