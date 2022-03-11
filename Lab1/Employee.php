<?php
include 'vendor/autoload.php';
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraint As Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Employee
{
    public int $id;
    public string $name;
    public int $salary;
    public DateTime $employed;
    private DateTime $created;

    public function getTime(): DateTime
    {
        return $created;
    }

    public static function checkEmployee()
    {
        $employee1 = new Employee(1, 'Ivan', 50000, new DateTime('21.05.2005'));
        $employee2 = new Employee(2, 'Y', 50000, new DateTime('21.05.2005'));
        $employee3 = new Employee(3, 'Ivan', -5000, new DateTime('21.05.2005'));
        
        $validator = Validation::createValidatorBuilder()
                ->addMethodMapping('loadValidatorMetadata')
                ->getValidator();
        
        $errors = $validator->validate($employee1);
        
        if (count($errors) != 0)
        {
            foreach ($errors as $error)
            {
                echo $error->getMessage() . '<br>';
            }
        }
        else 
        {
            echo 'Employee1 is valid<br>';
        }
        
        $errors = $validator->validate($employee2);
        
        if (count($errors) != 0)
        {
            foreach ($errors as $error)
            {
                echo $error->getMessage() . '<br>';
            }
        }
        else 
        {
            echo 'Employee2 is valid<br>';
        }
        
        $errors = $validator->validate($employee3);
        
        if (count($errors) != 0)
        {
            foreach ($errors as $error)
            {
                echo $error->getMessage() . '<br>';
            }
        }
        else 
        {
            echo 'Employee3 is valid<br>';
        }
    }

    public function getEx(): string
    {
        return date('Y', $created) - date('Y', $employed);
    }

    public function __construct(int $id, string $name, int $salary, DateTime $employed)
    {
        $this->id = $id;
        $this->name = $name;
        $this->salary = $salary;
        $this->employed = $employed;
        $this->created = new DateTime(date('d.m.Y H.i.s'));
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new NotBlank());
        $metadata->addPropertyConstraint('id', new Positive());
        $metadata->addPropertyConstraint('name', new NotBlank());
        $metadata->addPropertyConstraint('name', new NotNull());
        $metadata->addPropertyConstraint('name', new Length(array(
            'min'        => 2,
            'max'        => 27
        )));
        $metadata->addPropertyConstraint('salary', new NotBlank());
        $metadata->addPropertyConstraint('salary', new Positive());
        $metadata->addPropertyConstraint('employed', new NotBlank());
    }

    public function __toString(): string
    {
        return 'Id: ' . $this->id . " Name: " . $this->name . 
        " Salary: " . $this->salary . " Employed: " . $this->employed;
    }
}

Employee::checkEmployee();