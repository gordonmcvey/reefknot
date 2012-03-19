Reefknot PHP framework

This is very much a work in progress and at an early stage of development.  I do
think the validation package is up to the point where it's at least useful 
though, and I'm hoping to add packages on a regular basis.  

The first priority for Reefknot is to build a framework that follows best
practice both in terms of PHP coding and in terms of good coding in general.  
This means trying to stick to the following principles: 

* No magic methods unless it's unavoidable
* No Singletons or Registry objects
* Loose coupling
* Inversion of control via Dependency Injection
* Programming to interfaces to allow easy substitution of components
* Exceptions are reserved for exceptional events. Everything else is dealt with
  through traditional flow control
** Exceptions should only be thrown due to programmer error. A user of a 
   Reefknot application should never see an exception
* DRY
* Comprehensive unit tests with as little mocking of dependants or PHP services
  as possible. 

A reefknot is a common type knot used for a wide range of tasks
