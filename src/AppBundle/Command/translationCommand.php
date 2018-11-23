<?php

namespace AppBundle\Command;

use AppBundle\Entity\ArticleBis;
use AppBundle\Entity\ArticleTer;
use AppBundle\Entity\Block;
use AppBundle\Entity\BlockBis;
use AppBundle\Entity\BlockTer;
use AppBundle\Entity\Kitten;
use AppBundle\Entity\Page;
use AppBundle\Entity\PageBis;
use AppBundle\Entity\PageTer;
use AppBundle\WebService\GoogleTranslateInterface;
use Doctrine\Tests\Models\VersionedManyToOne\Article;
use Doctrine\Tests\ORM\Mapping\Dog;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TranslationCommand extends ContainerAwareCommand
{
    private $googleTranslateInterface;

    public function __construct(GoogleTranslateInterface $googleTranslateInterface)
    {
        parent::__construct();

        $this->googleTranslateInterface = $googleTranslateInterface;
    }

    protected function configure()
    {
        $this->setName('app:translate:translation-site')
            ->setDescription('Translate all site.')
            ->setHelp('Translate all site.');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            "Traduction du site",
            '============',
        ]);

        $locales = ['en', 'fr', 'it', 'es', 'de'];

        $classes = [
            'articles' => Article::class,
            'articlesBis' => ArticleBis::class,
            'articlesTer' => ArticleTer::class,
            'blocks' => Block::class,
            'blocksBis' => BlockBis::class,
            'blocksTer' => BlockTer::class,
            'pages' => Page::class,
            'pagesBis' => PageBis::class,
            'pagesTer' => PageTer::class,
            'kitten' => Kitten::class,
            'dogs' => Dog::class,
        ];

        foreach ($classes as $key => $class) {
            $articles = $this->getContainer()->get('doctrine')->getRepository($class)->findAll();

            foreach ($locales as $locale)
            {
                $this->googleTranslateInterface->getTranslate($articles, $locale, $class);
            }
        }

        $output->writeln([
            '============',
            'Le site est traduit',
        ]);
    }
}
