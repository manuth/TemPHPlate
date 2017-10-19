using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public class InlineStyle : StyleDefinition
    {
        public string Style
        {
            get => default(string);
            set
            {
            }
        }

        public override string Draw()
        {
            throw new NotImplementedException();
        }
    }
}