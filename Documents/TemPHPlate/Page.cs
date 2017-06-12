using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public class Page : WebContent, IMenuPage
    {

        public MenuBar MenuBar { get => throw new NotImplementedException(); set => throw new NotImplementedException(); }
        public bool SupportsMenuBar { get => throw new NotImplementedException(); set => throw new NotImplementedException(); }

        public override string Print()
        {
            throw new NotImplementedException();
        }
    }
}