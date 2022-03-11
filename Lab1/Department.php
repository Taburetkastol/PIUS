<?php
require_once 'Employee.php';
use Symfony\Component\Validator\Constraints\DateTime;

class Department
{
    public array $employees;
    public string $name;

    public function __construct($employees, $name)
    {
        $this->employees = $employees;
        $this->name = $name;
    }

    public function getSumOfSalaries(): int
    {
        $sum = 0;

        foreach ($this->employees as $employee)
        {
            $sum += $employee->salary;
        }

        return $sum;
    }

    public static function checkDepartment()
    {
        $employee11 = new Employee(1, 'Ivan', 50000, new DateTime('21.05.2005'));
        $employee12 = new Employee(2, 'Ywq', 25000, new DateTime('21.05.2005'));
        $employee13 = new Employee(3, 'Ivan', 15000, new DateTime('21.05.2005'));
        $employee21 = new Employee(1, 'Ivan', 75000, new DateTime('21.05.2005'));
        $employee22 = new Employee(2, 'Yeqw', 100000, new DateTime('21.05.2005'));
        $employee23 = new Employee(3, 'Ivan', 53000, new DateTime('21.05.2005'));
        $employee31 = new Employee(1, 'Ivan', 50000, new DateTime('21.05.2005'));
        $employee32 = new Employee(2, 'Yrqw', 25000, new DateTime('21.05.2005'));
        $employee33 = new Employee(3, 'Ivan', 15000, new DateTime('21.05.2005'));
        $employee34 = new Employee(4, 'Ivan', 7500, new DateTime('21.05.2005'));
        
        $department1 = new Department(array($employee11, $employee12, $employee13), 'Department 1');
        $department2 = new Department(array($employee21, $employee22, $employee23), 'Department 2');
        $department3 = new Department(array($employee31, $employee32, $employee33), 'Department 3');
        echo $department1->getSumOfSalaries() . '<br>';
        echo $department2->getSumOfSalaries() . '<br>';
        echo $department3->getSumOfSalaries() . '<br>';

        $departments = array($department1, $department2, $department3);
        echo 'Min: ' . getMinDepartment($departments)->name . '<br>';
        echo 'Max: '. getMaxDepartment($departments)->name . '<br>';
    }
}

function getMinDepartment(array $departments): Department
{
    $min = 21472839;
    $minDepartment;
    foreach ($departments as $department)
    {
        $sum = $department->getSumOfSalaries();
        if ($sum < $min)
        {
            $min = $sum;
            $minDepartment = $department;
        }
    }

    foreach ($departments as $department)
    {
        if ($minDepartment->getSumOfSalaries() == $department->getSumOfSalaries())
        {
            if (count($minDepartment->employees) < count($department->employees))
            {
                $minDepartment = $department;
            }
            else if (count($minDepartment->employees) == count($department->employees) 
            && $minDepartment->name != $department->name)
            {
                echo $department->name;
            }
        }
    }
    
    return $minDepartment;
}

function getMaxDepartment(array $departments): Department
{
    $max = 0;
    $maxDepartment;
    foreach ($departments as $department)
    {
        $sum = $department->getSumOfSalaries();
        if ($sum > $max)
        {
            $max = $sum;
            $maxDepartment = $department;
        }
    }

    foreach ($departments as $department)
    {
        if ($maxDepartment->getSumOfSalaries() == $department->getSumOfSalaries())
        {
            if (count($maxDepartment->employees) < count($department->employees))
            {
                $maxDepartment = $department;
            }
            else if (count($maxDepartment->employees) == count($department->employees)
            && $maxDepartment->name != $department->name)
            {
                echo $department->name;
            }
        }
    }

    return $maxDepartment;
}

Department::checkDepartment();