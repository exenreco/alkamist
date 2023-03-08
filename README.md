# Alkamist
    An ongoing WordPress theme created for my 2023 portfolio website. The theme is built on wordPress and Gutenberg. Over time this theme might grow into being an hybrid WordPress theme with a small number of features that allows it to run as a classic wordpress theme.

# Demos
    Portfolio: https://www.exenreco.x10.mx
    sticky: https://www.exenreco.x10.mx/demo/sticky
    fixed: https://www.exenreco.x10.mx/demo/fixed
# Whats inside
    As of version 1.0.0 expect:
        - pre-packaged patterns such as:
            header variactions [sticky, fixed, slider, media, canvas, social-icon-in-nav]
            footer variations [sticky, fixed, one-column, two-column, three-column]

        - pre-packaged blocks such as:
            Sticky area block
            Slider/Corsola Block
            Copyright Block

# Usesage

# Optimization
    I know this theme is not fully optimized and no I will not optimize this theme aytime soon,
    this is so since this is considered an on going project and I might change stuff arround over time. However, below is an insight of how you could go about optimizing this project:
        - Optimizing classes
        If you have notice there are multiple classes in the classes directory that uses a similar structure of the Setup class. All classes with a simular structure could extend the Setup class which allows sub classes to inherit redundant methods. There are quite a few redundant method since
        I just copied methods from setup class so this project could be done in a timely manor.

        - Optimizing redundant spaghetti codes
        There are multiple repeated lines of code that does fairly similar things. These repeated lines of codes can be put into a function and only call that function when the function is needed.

        - Repeated functions
        There are quite a few wordPress functions and theme functions being call with in a single function right ater they were previously called. The theme can run alot faster if these fuctions was loop using a for or while loop.

        - Global variables
        Currently the theme only has one global variable "THEME", There are a few more variable that could be made global that could improve optimization, these includes but is not limited to: namespace & texdomain.

