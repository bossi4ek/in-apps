<?php

namespace Frontend\AndroidBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\Gherkin\Exception\Exception;
use Behat\Behat\Context\Step;
//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext implements KernelAwareInterface
//class FeatureContext extends BehatContext //MinkContext if you want to test web
//                  implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /the following content exist:/
     */
    public function theContentExist(TableNode $table)
    {
        $container = $this->kernel->getContainer()->get('content');

        $hash = $table->getHash();
        foreach ($hash as $row) {
            $content = $container->findOneBySlug($row['slug']);

            if (isset($content)) {
                echo "Content (".$row['slug'].") - exist\n";
            }
            else {
                throw new Exception(
                    "Content (".$row['slug'].") not found:\n"
                );
            }
        }
    }

    /**
     * @Given /^I logged in as "([^"]*)" with "([^"]*)" password$/
     */
    public function iLoggedInAsWithPassword($username, $password)
    {
        return array(
            new Step\Given("I am on \"/login\""),
            new Step\When("I fill in \"username\" with \"$username\""),
            new Step\When("I fill in \"password\" with \"$password\""),
            new Step\When("I press \"security.login.submit\""),
            new Step\Then("I should be on \"/home\""),
        );
    }

//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        $container = $this->kernel->getContainer();
//        $container->get('some_service')->doSomethingWith($argument);
//    }

}
