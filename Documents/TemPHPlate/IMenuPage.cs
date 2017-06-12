using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public interface IMenuPage
    {
        MenuBar MenuBar { get; set; }
        bool SupportsMenuBar { get; set; }
    }
}