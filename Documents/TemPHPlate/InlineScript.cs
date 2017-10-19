using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace TemPHPlate
{
    public class InlineScript : ScriptDefinition
    {
        public string ScriptBody
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